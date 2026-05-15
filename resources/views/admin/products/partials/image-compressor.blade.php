<script>
(function () {
  const maxSide = 1600;
  const quality = 0.82;
  const jobs = new WeakMap();

  function productImageInputs() {
    return Array.from(document.querySelectorAll('input[type="file"][name="image[]"]'));
  }

  function canCompress(file) {
    return /^image\/(jpe?g|png|webp)$/i.test(file.type || '') && file.size > 450000;
  }

  function loadImage(file) {
    return new Promise(function (resolve, reject) {
      const url = URL.createObjectURL(file);
      const image = new Image();

      image.onload = function () {
        URL.revokeObjectURL(url);
        resolve(image);
      };

      image.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Image preview failed'));
      };

      image.src = url;
    });
  }

  async function compressFile(file) {
    if (!canCompress(file) || typeof File !== 'function') {
      return file;
    }

    const image = await loadImage(file);
    const sourceWidth = image.naturalWidth || image.width;
    const sourceHeight = image.naturalHeight || image.height;

    if (!sourceWidth || !sourceHeight) {
      return file;
    }

    const scale = Math.min(1, maxSide / Math.max(sourceWidth, sourceHeight));

    if (scale === 1 && file.size < 900000) {
      return file;
    }

    const canvas = document.createElement('canvas');
    canvas.width = Math.max(1, Math.round(sourceWidth * scale));
    canvas.height = Math.max(1, Math.round(sourceHeight * scale));

    const context = canvas.getContext('2d', { alpha: false });
    if (!context) {
      return file;
    }

    context.fillStyle = '#fff';
    context.fillRect(0, 0, canvas.width, canvas.height);
    context.drawImage(image, 0, 0, canvas.width, canvas.height);

    const blob = await new Promise(function (resolve) {
      canvas.toBlob(resolve, 'image/jpeg', quality);
    });

    if (!blob || blob.size >= file.size) {
      return file;
    }

    const name = file.name.replace(/\.[^.]+$/, '') + '.jpg';

    return new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() });
  }

  async function optimizeInput(input) {
    const files = Array.from(input.files || []);

    if (!files.length || input.dataset.optimized === '1') {
      return;
    }

    input.dataset.optimizing = '1';
    toggleSubmit(input.form, true);

    try {
      const optimizedFiles = await Promise.all(files.map(compressFile));
      const changed = optimizedFiles.some(function (file, index) {
        return file !== files[index];
      });

      if (changed && typeof DataTransfer === 'function') {
        const transfer = new DataTransfer();
        optimizedFiles.forEach(function (file) {
          transfer.items.add(file);
        });
        input.files = transfer.files;
      }

      input.dataset.optimized = '1';
    } catch (error) {
      console.warn('Product image compression skipped:', error);
    } finally {
      input.dataset.optimizing = '0';
      toggleSubmit(input.form, false);
      input.dispatchEvent(new CustomEvent('images:optimized'));
    }
  }

  function toggleSubmit(form, disabled) {
    if (!form) {
      return;
    }

    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (button) {
      button.disabled = disabled;
    });
  }

  productImageInputs().forEach(function (input) {
    input.addEventListener('change', function () {
      input.dataset.optimized = '0';
      const job = optimizeInput(input);
      jobs.set(input, job);
    });
  });

  document.addEventListener('submit', async function (event) {
    const form = event.target;
    const inputs = productImageInputs().filter(function (input) {
      return input.form === form;
    });

    const pending = inputs
      .filter(function (input) {
        return input.dataset.optimizing === '1';
      })
      .map(function (input) {
        return jobs.get(input);
      })
      .filter(Boolean);

    if (!pending.length) {
      return;
    }

    event.preventDefault();
    await Promise.allSettled(pending);
    form.requestSubmit(event.submitter || form.querySelector('button[type="submit"], input[type="submit"]'));
  }, true);
})();
</script>

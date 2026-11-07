(() => {
  const update = () => {
    const mainPrice = document.querySelector('[data-sale-price]')?.value;
    const variantPrices = [...document.querySelectorAll('input[name="sizes[price][]"]')]
      .map((input) => Number(input.value))
      .filter((price) => Number.isFinite(price) && price > 0);
    const current = Number(mainPrice || (variantPrices.length ? Math.min(...variantPrices) : 0));
    const originalInput = document.querySelector('[data-old-price]');
    const original = Number(originalInput?.value || 0);
    const preview = document.querySelector('[data-discount-preview]');
    const validSale = original > current && current >= 0;

    if (preview) preview.textContent = validSale ? `${Math.round((1 - current / original) * 100)}% zbritje` : '—';
    if (originalInput) {
      originalInput.setCustomValidity(original > 0 && !validSale
        ? 'Çmimi real duhet të jetë më i lartë se çmimi aktual.'
        : '');
    }
  };

  document.addEventListener('input', (event) => {
    if (event.target.matches('[data-sale-price], [data-old-price], input[name="sizes[price][]"]')) update();
  });
  document.addEventListener('DOMContentLoaded', update);
  update();
})();

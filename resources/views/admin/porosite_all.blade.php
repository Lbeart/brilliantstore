<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Krejt Porositë – Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f8f9fa;font-family:'Segoe UI',sans-serif}
    .card-soft{background:#fff;border:0;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.06)}
    .badge-status{font-size:.8rem}
  </style>
</head>
<body>
<div class="container-fluid py-3">

  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h5 m-0">Krejt Porositë ({{ $orders->count() }})</h1>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">⟵ Kthehu te lista me filtra</a>
      <a href="{{ route('admin.orders.all') }}" class="btn btn-outline-dark">Rifresko</a>
    </div>
  </div>

  <!-- Statistika -->
  <div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
      <div class="card-soft p-3 text-center">
        <div class="text-muted">Porosi</div>
        <div class="fs-4 fw-bold">{{ $count ?? 0 }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-soft p-3 text-center">
        <div class="text-muted">Të ardhura</div>
        <div class="fs-4 fw-bold">{{ number_format($revenue ?? 0, 2) }} €</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-soft p-3 text-center">
        <div class="text-muted">Mesatarja / porosi</div>
        <div class="fs-4 fw-bold">{{ number_format($avg ?? 0, 2) }} €</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-soft p-3 text-center">
        <div class="text-muted">Artikuj gjithsej</div>
        <div class="fs-4 fw-bold">{{ $itemsQty ?? 0 }}</div>
      </div>
    </div>
  </div>

  <!-- Status breakdown -->
  <div class="row g-3 mb-3">
    @php $map=['new'=>'primary','processing'=>'warning','completed'=>'success','canceled'=>'secondary']; @endphp
    @foreach(['new'=>'Të reja','processing'=>'Në proces','completed'=>'Përfunduara','canceled'=>'Anuluara'] as $k=>$label)
      <div class="col-6 col-md-3">
        <div class="card-soft p-3 text-center">
          <span class="badge bg-{{ $map[$k] ?? 'secondary' }} text-uppercase">{{ $label }}</span>
          <div class="fs-5 fw-semibold mt-1">{{ $byStatus[$k] ?? 0 }}</div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Kërkim & Data -->
  <form method="get" class="card-soft p-3 mb-3">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-6">
        <label class="form-label mb-1">Kërko</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control"
                 placeholder="Emri, telefoni, emaili ose #ID…">
        </div>
      </div>
      <div class="col-6 col-md-3">
        <label class="form-label mb-1">Nga data</label>
        <input type="date" name="from" value="{{ $from ?? '' }}" class="form-control">
      </div>
      <div class="col-6 col-md-3">
        <label class="form-label mb-1">Deri më</label>
        <input type="date" name="to" value="{{ $to ?? '' }}" class="form-control">
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
        <button class="btn btn-outline-secondary w-100" type="submit">Kërko</button>
      </div>
      <div class="col-6 col-md-2">
        <label class="form-label mb-1 d-none d-md-block">&nbsp;</label>
        <a href="{{ route('admin.orders.all') }}" class="btn btn-secondary w-100">Hiq filtrat</a>
      </div>
    </div>
  </form>

  <div class="card-soft p-3">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
        <tr>
          <th style="width:70px">#</th>
          <th>Klienti</th>
          <th>Kontakti</th>
          <th style="width:120px">Totali</th>
          <th style="width:100px">Artikuj</th>
          <th style="width:140px">Statusi</th>
          <th style="width:160px">Data</th>
          <th style="width:90px"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $o)
          <tr>
            <td>{{ $o->id }}</td>
            <td>
              <div class="fw-semibold">{{ $o->name }}</div>
              <div class="text-muted small">
                {{ $o->address }}@if($o->city), {{ $o->city }}@endif @if($o->zip) ({{ $o->zip }})@endif
              </div>
            </td>
            <td class="small">
              <div><i class="fa fa-phone me-1"></i>{{ $o->phone }}</div>
              @if($o->email)<div><i class="fa fa-envelope me-1"></i>{{ $o->email }}</div>@endif
            </td>
            <td>{{ number_format($o->total,2) }} €</td>
            <td>{{ $o->items_count }}</td>
            <td>
              <span class="badge bg-{{ $map[$o->status] ?? 'secondary' }} text-uppercase">{{ $o->status }}</span>
            </td>
            <td class="small text-muted">{{ $o->created_at->format('d.m.Y H:i') }}</td>
            <td class="text-end">
              <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-dark">
                <i class="fa fa-eye"></i>
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">S’ka porosi.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

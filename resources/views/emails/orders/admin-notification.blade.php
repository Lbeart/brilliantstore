<x-mail::message>
# Porosi e re #{{ $order->id }}

**Kodi i gjurmimit:** {{ $order->tracking_code }}<br>
**Klienti:** {{ $order->name }}<br>
**Telefoni:** {{ $order->phone }}<br>
**Email:** {{ $order->email ?: '—' }}<br>
**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

## Artikujt
| Produkti | Dimensioni | Ngjyra | Sasia | Çmimi | Totali |
|:--|:--:|:--:|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->size ?? '—' }} | {{ $it->color ?? '—' }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali:** **{{ number_format($order->total,2) }} €**<br>
**Pagesa:** {{ strtoupper($order->payment) }}<br>
**Statusi:** {{ strtoupper($order->status) }}

<x-mail::button :url="route('admin.orders.show', $order)">Hape porosinë në admin</x-mail::button>
</x-mail::message>

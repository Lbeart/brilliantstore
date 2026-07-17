<x-mail::message>
# Përshëndetje {{ $order->name }},

Porosia juaj **#{{ $order->id }}** u pranua me sukses.

**Kodi i gjurmimit:** {{ $order->tracking_code }}<br>
**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

## Artikujt
| Produkti | Dimensioni | Ngjyra | Sasia | Çmimi | Totali |
|:--|:--:|:--:|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->size ?? '—' }} | {{ $it->color ?? '—' }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali:** **{{ number_format($order->total,2) }} €**<br>
**Pagesa:** {{ strtoupper($order->payment) }}

@if(isset($orderUrl))
<x-mail::button :url="$orderUrl">Gjurmo porosinë</x-mail::button>
@endif

Faleminderit,<br>
**B-Brillant**
</x-mail::message>

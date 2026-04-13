<x-mail::message>
# Përshëndetje {{ $order->name }},

Na vjen keq t'ju njoftojmë se porosia juaj **#{{ $order->id }}** është **anuluar**.

@if($reason)
**Arsye:**
> {{ $reason }}

@endif
**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

## Artikujt
| Produkti | Sasia | Çmimi | Totali |
|:--|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali:** **{{ number_format($order->total,2) }} €**

Nëse dëshironi të porosisni diçka tjetër, mund të na kontaktoni përsëri. Ne jemi këtu për t'ju ndihmuar.

Faleminderit,
**Brillant**
</x-mail::message>

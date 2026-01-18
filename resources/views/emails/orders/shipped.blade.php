<x-mail::message>
# Përshëndetje {{ $order->name }},

Porosia juaj **#{{ $order->id }}** është **nisur** dhe është rrugës drejt jush.  
Ja përmbledhja:

**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

## Artikujt
| Produkti | Sasia | Çmimi | Totali |
|:--|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali:** **{{ number_format($order->total,2) }} €**

Faleminderit për blerjen!  
**Brillant**
</x-mail::message>

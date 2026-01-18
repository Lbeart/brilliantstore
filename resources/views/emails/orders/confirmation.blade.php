<x-mail::message>
# Përshëndetje {{ $order->name }},

Porosia juaj **#{{ $order->id }}** u pranua me sukses dhe është në procesim.  
Më poshtë janë detajet:

**Emri:** {{ $order->name }}  
**Telefoni:** {{ $order->phone }}  
@if($order->email)
**Email:** {{ $order->email }}
@endif  
**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

@if($order->notes)
**Shënime:** {{ $order->notes }}
@endif

## Artikujt
| Produkti | Dimensioni | Sasia | Çmimi | Totali |
|:--|:--:|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->size ?? '—' }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali:** **{{ number_format($order->total,2) }} €**  
**Pagesa:** {{ strtoupper($order->payment) }}

@if(isset($orderUrl))
<x-mail::button :url="$orderUrl">
Shiko porosinë
</x-mail::button>
@endif

Nëse keni pyetje, mund t’i përgjigjeni këtij emaili.

Faleminderit,  
**Brillant**
</x-mail::message>

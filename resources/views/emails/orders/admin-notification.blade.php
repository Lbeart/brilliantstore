<x-mail::message>
# Porosi e Re - Notikim Administratori

Nje porosi e re u regjistrua në website! Detajet e porosisë:

**Kodi i ndjekjes:** {{ $order->tracking_code }}  
**ID Porosisë:** {{ $order->id }}

## Informacioni i Klientit

**Emri:** {{ $order->name }}  
**Email:** {{ $order->email }}  
**Telefoni:** {{ $order->phone }}  
**Adresa:** {{ $order->address }}@if($order->city), {{ $order->city }}@endif @if($order->zip) ({{ $order->zip }})@endif

@if($order->notes)
**Shënime:** {{ $order->notes }}
@endif

## Artikujt e Porosisë

| Produkti | Dimensioni | Sasia | Çmimi | Totali |
|:--|:--:|:--:|--:|--:|
@foreach($order->items as $it)
| {{ $it->name }} | {{ $it->size ?? '—' }} | {{ $it->qty }} | {{ number_format($it->price,2) }} € | {{ number_format($it->price * $it->qty,2) }} € |
@endforeach

**Totali Porosisë:** **{{ number_format($order->total,2) }} €**  
**Metoda e Pagesës:** {{ strtoupper($order->payment) }}  
**Statusi:** {{ strtoupper($order->status) }}

<x-mail::button :url="route('admin.orders.show', $order)">
Shiko Porosinë në Admin
</x-mail::button>

---
Këtë porosi u regjistrua më: {{ $order->created_at->format('d.m.Y H:i') }}
</x-mail::message>

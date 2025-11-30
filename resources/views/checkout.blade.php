@extends('layouts.app')
@section('content')
<main class="py-10 min-h-screen bg-pamsucolo-bg">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-pamsucolo-primary">Checkout</h1>
        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 rounded p-4 text-sm">{{ session('error') }}</div>
        @endif
        @if($cart->isEmpty())
            <p>Your bag is empty. <a href="{{ route('shop') }}" class="text-pamsucolo-primary hover:underline">Go back to shop.</a></p>
        @else
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <table class="w-full text-left mb-4">
                <thead class="bg-gray-100">
                    <tr class="font-bold">
                        <th class="py-2 px-2">Product</th>
                        <th class="py-2 px-2 text-center">Qty</th>
                        <th class="py-2 px-2 text-right">Price</th>
                        <th class="py-2 px-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item->quantity * $item->product->price; $total += $subtotal; @endphp
                    <tr>
                        <td class="py-3 px-2">{{ $item->product->name }}</td>
                        <td class="py-3 px-2 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 px-2 text-right">₱{{ number_format($item->product->price,2) }}</td>
                        <td class="py-3 px-2 text-right font-semibold">₱{{ number_format($subtotal,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-right font-bold text-xl">Total: ₱{{ number_format($total,2) }}</div>
        </div>
        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-3 rounded-lg bg-pamsucolo-primary text-white font-bold text-lg hover:bg-pamsucolo-primary/90 transition">Place Order</button>
        </form>
        @endif
    </div>
</main>
@endsection

@extends('layouts.app')
@section('content')
<main class="py-10 bg-pamsucolo-bg min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-pamsucolo-primary">My Bag</h1>
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-900 rounded p-4 text-sm">{{ session('success') }}</div>
        @endif
        @if($cart->isEmpty())
            <p>Your bag is empty. <a href="{{ route('shop') }}" class="text-pamsucolo-primary hover:underline">Shop now.</a></p>
        @else
        <div class="space-y-6 mb-8">
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php $product = $item->product; $total += $product->price * $item->quantity; @endphp
                <div class="bg-white p-4 rounded-xl shadow-lg border flex items-center justify-between gap-4">
                    <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" class="h-20 w-20 object-cover rounded-lg" alt="{{ $product->name }}">
                    <div class="flex-1">
                        <div class="text-lg font-bold">{{ $product->name }}</div>
                        <div class="text-gray-500 text-sm">{{ $product->type }} | Size: {{ $product->size }}</div>
                        <div class="text-pamsucolo-primary font-bold">₱{{ number_format($product->price,2) }}</div>
                    </div>
                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <label class="text-sm text-gray-600">Qty:</label>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 border rounded px-2 py-1 text-center">
                        <button type="submit" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Update</button>
                    </form>
                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="pt-4 border-t flex justify-between items-center">
            <span class="text-lg font-bold">Total: ₱{{ number_format($total,2) }}</span>
            <a href="{{ route('checkout.index') }}" class="py-2 px-6 rounded-lg bg-pamsucolo-primary text-white font-bold hover:bg-pamsucolo-primary/90 transition">Proceed to Checkout</a>
        </div>
        @endif
    </div>
</main>
@endsection

@extends('layouts.app')
@section('content')
<main class="py-10 bg-pamsucolo-bg min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-pamsucolo-primary">Shop Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($products as $product)
            <div class="bg-white p-4 rounded-xl shadow-lg border flex flex-col">
                <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" alt="{{ $product->name }}" class="object-cover h-40 w-full rounded mb-3">
                <h2 class="text-lg font-semibold mb-1">{{ $product->name }}</h2>
                <p class="text-gray-500">{{ $product->type }} | Size: {{ $product->size }}</p>
                <p class="font-bold text-pamsucolo-primary mt-2 mb-1 text-xl">₱{{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-gray-600 my-2 flex-grow">{{ $product->short_description }}</p>
                <div class="mt-3">
                    <a href="{{ route('product.show', $product) }}" class="text-pamsucolo-primary hover:underline text-sm">View Details</a>
                </div>
                @auth
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full py-2 rounded font-bold text-white bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 transition">Add to Bag</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="block w-full py-2 mt-2 rounded font-bold text-white bg-pamsucolo-primary text-center">Login to purchase</a>
                @endauth
            </div>
        @endforeach
        </div>
    </div>
</main>
@endsection

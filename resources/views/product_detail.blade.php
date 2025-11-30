@extends('layouts.app')
@section('content')
<main class="py-10 min-h-screen bg-pamsucolo-bg">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col md:flex-row gap-8">
            <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" class="w-60 h-60 object-cover rounded-lg border self-center md:self-start" alt="{{ $product->name }}">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-pamsucolo-primary mb-2">{{ $product->name }}</h1>
                <div class="text-gray-600 mb-2">{{ $product->type }} | Size: {{ $product->size }}</div>
                <div class="text-2xl font-extrabold text-pamsucolo-primary mb-2">₱{{ number_format($product->price,2) }}</div>
                <div class="mb-4 text-gray-700 text-sm">{{ $product->short_description }}</div>
                @auth
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-3 px-8 rounded-lg bg-pamsucolo-primary text-white font-bold hover:bg-pamsucolo-primary/90 transition">Add to Bag</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 px-6 rounded-lg bg-pamsucolo-primary text-white font-bold text-center mb-3">Log in to add to bag</a>
                @endauth
                <a href="{{ route('shop') }}" class="text-pamsucolo-primary hover:underline text-sm mt-5 inline-block">&#8592; Back to Shop</a>
            </div>
        </div>
    </div>
</main>
@endsection

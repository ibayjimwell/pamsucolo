@extends('layouts.app')
@section('content')
    <header class="relative bg-cover bg-center h-96 sm:h-[400px] flex items-center" style="background-image: url('{{ asset('background.png') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white z-10">
            <div class="bg-white/10 backdrop-blur-sm p-6 sm:p-8 rounded-lg max-w-lg mt-16">
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-3">Your Campus, Your Store.</h1>
                <p class="text-lg mb-6 font-light">Get your essentials from Lanyards to Department Shirts plus built-in student loans.</p>
                @guest
                    <a href="{{ route('login') }}" class="inline-block bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300 mb-2">Login to Shop</a>
                @else
                    <a href="{{ route('shop') }}" class="inline-block bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300 mb-2">Start Shopping Now</a>
                @endguest
            </div>
        </div>
    </header>

    <section class="py-12 px-4 sm:px-6 lg:px-8 -mt-20 z-20 relative">
        <div class="max-w-5xl mx-auto bg-pamsucolo-primary text-white p-8 sm:p-10 rounded-xl shadow-2xl">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">On-campus marketplace with built-in student loans</h2>
            <p class="mb-6 opacity-90 hidden sm:block">Access what you need, when you need it. Flexible payment solutions for every student.</p>
            @auth
            <a href="{{ route('account') }}" class="inline-block bg-white text-pamsucolo-primary font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-300">My Account</a>
            @else
            <a href="{{ route('register') }}" class="inline-block bg-white text-pamsucolo-primary font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-300">Create Account</a>
            @endauth
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-pamsucolo-text mb-6">Product Categories</h2>
            <div class="flex overflow-x-auto space-x-4 pb-2 snap-x sm:grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 sm:space-x-0 sm:gap-6">
                <div class="flex-shrink-0 w-40 sm:w-auto snap-center text-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 cursor-pointer">
                    <div class="flex justify-center mb-3">
                        <div class="w-20 h-20 bg-pamsucolo-primary/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pamsucolo-primary" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f89458" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 8h-3"/><path d="m15 2-1 2h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3"/><path d="M16.899 22A5 5 0 0 0 7.1 22"/><path d="m9 2 3 6"/><circle cx="12" cy="15" r="3"/></svg>
                        </div>
                    </div>
                    <p class="font-semibold text-lg">Lanyard</p>
                </div>
                <div class="flex-shrink-0 w-40 sm:w-auto snap-center text-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 cursor-pointer">
                    <div class="flex justify-center mb-3">
                        <div class="w-20 h-20 bg-pamsucolo-primary/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pamsucolo-primary" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f89458" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 11H3c-.6 0-1-.4-1-1V6c0-1.1.8-2.3 1.9-2.6L8 2a4 4 0 0 0 8 0l4.1 1.4C21.2 3.7 22 4.9 22 6v4c0 .6-.4 1-1 1h-3"/><path d="M18 8v13c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V8"/></svg>
                        </div>
                    </div>
                    <p class="font-semibold text-lg">Department Shirt</p>
                </div>
                <div class="flex-shrink-0 w-40 sm:w-auto snap-center text-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 cursor-pointer">
                    <div class="flex justify-center mb-3">
                        <div class="w-20 h-20 bg-pamsucolo-primary/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pamsucolo-primary" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f89458" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v15a2 2 0 1 0 4 0V7c0-.6-.4-1-1-1h-3"/><path d="M7 3v1a3 3 0 1 0 6 0V3"/><path d="M10 11h.01"/><path d="M10 15h.01"/></svg>
                        </div>
                    </div>
                    <p class="font-semibold text-lg">Uniform</p>
                </div>
                <div class="flex-shrink-0 w-40 sm:w-auto snap-center text-center p-4 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 cursor-pointer">
                    <div class="flex justify-center mb-3">
                        <div class="w-20 h-20 bg-pamsucolo-primary/20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-pamsucolo-primary" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f89458" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M17 12h.01"/><path d="M12 12h.01"/><path d="M7 12h.01"/></svg>
                        </div>
                    </div>
                    <p class="font-semibold text-lg">Accessories</p>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('shop') }}" class="text-pamsucolo-primary font-medium hover:underline flex items-center justify-center">
                    See All Products
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </section>
        <hr class="my-12 border-gray-200">
        <section class="mt-20 mb-20">
            <div class="bg-gray-100 p-8 sm:p-12 rounded-xl text-center">
                <h3 class="text-3xl sm:text-4xl font-extrabold text-pamsucolo-text mb-4">
                    📚 Hassle Free, Shop Anywhere, Shop Easier.
                </h3>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    <strong>PamSuCoLo</strong> is your trusted partner for campus life, bridging the gap between student necessities and financial accessibility. <strong>Flexibility</strong> and <strong>Transparency</strong> in every transaction.
                </p>
            </div>
        </section>
    </main>
@endsection

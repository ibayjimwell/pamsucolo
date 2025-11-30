<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Pamsucolo</title>
    <style>
        /* Optional: Your background color/theme settings */
        body {
            background-color: var(--color-pamsucolo-bg);
            color: var(--color-pamsucolo-text);
        }
    </style>
</head>
<body class="bg-pamsucolo-bg text-pamsucolo-text font-sans antialiased">
    <nav class="sticky top-0 z-40 bg-white shadow-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-2">
                    <img class="w-10 h-10" src="{{ asset('logo.png') }}" alt="PamSuCoLo Logo">
                    <a href="{{ route('main') }}" class="text-2xl font-bold text-pamsucolo-primary">PamSuCoLo</a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('main') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('main') ? 'text-pamsucolo-primary border-b-2 border-pamsucolo-primary' : 'text-gray-900 hover:text-pamsucolo-primary' }}">Home</a>
                    <a href="{{ route('shop') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('shop','product.show') ? 'text-pamsucolo-primary border-b-2 border-pamsucolo-primary' : 'text-gray-900 hover:text-pamsucolo-primary' }}">Shop</a>
                    <a href="{{ route('account') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('account') ? 'text-pamsucolo-primary border-b-2 border-pamsucolo-primary' : 'text-gray-900 hover:text-pamsucolo-primary' }} @guest hidden @endguest">My Account</a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-pamsucolo-primary border-b-2 border-pamsucolo-primary' : 'text-gray-900 hover:text-pamsucolo-primary' }}">Admin</a>
                        @endif
                    @endauth
                </div>
                <div class="flex items-center space-x-2">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-pamsucolo-primary focus:outline-none">
                            <span class="absolute -top-1 -right-1 w-4 h-4 text-xs bg-pamsucolo-primary text-white rounded-full flex items-center justify-center font-semibold">
                                {{ \App\Models\CartItem::where('user_id',auth()->id())->count() }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10a4 4 0 0 1-8 0"/><path d="M3.103 6.034h17.794"/><path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z"/></svg>
                        </a>
                        <a href="{{ route('account') }}" class="p-2 text-gray-500 hover:text-pamsucolo-primary focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-pamsucolo-primary px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-pamsucolo-primary text-white px-3 py-2 rounded font-bold">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @yield('content')
    <footer class="bg-gray-900 text-white mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                <div class="col-span-2 md:col-span-1">
                    <img class="w-10 h-10" src="{{ asset('logo.png') }}" alt="PamSuCoLo Logo">
                    <h4 class="text-2xl font-bold text-pamsucolo-primary mb-3">PamSuCoLo</h4>
                    <p class="text-sm text-gray-400">Your dedicated on-campus E-commerce solution.</p>
                </div>
                <div>
                    <h5 class="font-semibold text-white mb-3 uppercase text-sm">Shop</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('shop') }}" class="hover:text-pamsucolo-primary transition">Shop All</a></li>
                        <!-- Add more category links if needed -->
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-white mb-3 uppercase text-sm">Financial</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('account') }}" class="hover:text-pamsucolo-primary transition">Apply for Loan</a></li>
                        <!-- Add loan calculator/payment options if implemented -->
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-white mb-3 uppercase text-sm">About</h5>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-pamsucolo-primary transition">About Us</a></li>
                        <li><a href="#" class="hover:text-pamsucolo-primary transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-pamsucolo-primary transition">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center">
                <p class="text-sm text-gray-500">&copy; 2025 PamSuCoLo. All rights reserved. Built for students.</p>
            </div>
        </div>
    </footer>
</body>
</html>
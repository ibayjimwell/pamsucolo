@extends('layouts.app')
@section('content')
<div class="bg-pamsucolo-bg min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-3">
        <h1 class="text-3xl font-bold text-pamsucolo-primary mb-6">Admin Dashboard</h1>
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-900 rounded p-4 text-sm">{{ session('success') }}</div>
        @endif
        <div x-data="{ tab: 'products' }">
        <div class="flex space-x-6 mb-8">
            <button x-on:click="tab='products'" :class="tab==='products' ? 'text-pamsucolo-primary font-bold' : ''">Products</button>
            <button x-on:click="tab='loans'" :class="tab==='loans' ? 'text-pamsucolo-primary font-bold' : ''">Loans</button>
            <button x-on:click="tab='account'" :class="tab==='account' ? 'text-pamsucolo-primary font-bold' : ''">My Account</button>
        </div>
        <!-- Products Tab -->
        <div x-show="tab==='products'">
            <div class="flex gap-12 flex-wrap mb-8">
                <!-- Add Product -->
                <div class="flex-1 min-w-[300px] bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Add Product</h2>
                    <form action="{{ route('admin.product.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input name="image_url" type="url" class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base" placeholder="Image URL">
                        <input name="name" type="text" class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base" placeholder="Product Name" required>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="product_type" class="block text-sm font-medium text-gray-700">Product Type</label>
                                <select id="product_type" name="type" required
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                                    <option value="Lanyard">Lanyard</option>
                                    <option value="Department Shirt">Department Shirt</option>
                                    <option value="Uniform">Uniform</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700">Size</label>
                                <select id="size" name="size" required
                                    class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base">
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="N/A">N/A (e.g., Lanyard)</option>
                                </select>
                            </div>
                        </div>
                        <input name="price" type="number" step="0.01" class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base" placeholder="Price" required>
                        <textarea name="short_description" class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-base" placeholder="Short Description"></textarea>
                        <button type="submit" class="w-full py-2 bg-pamsucolo-primary text-white rounded font-bold">Add Product</button>
                    </form>
                </div>
                <!-- Products List -->
                <div class="flex-[2] min-w-[350px]">
                    <h2 class="text-xl font-bold mb-4">Current Products</h2>
                    <div class="space-y-4">
                        @foreach($products as $product)
                        <div class="flex items-center bg-white p-4 rounded-xl shadow border">
                            <img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" class="h-16 w-16 object-cover rounded mr-3">
                            <div class="flex-1 min-w-0">
                                <div class="font-bold">{{ $product->name }}</div>
                                <div class="text-sm text-gray-600">{{ $product->type }} | Size: {{ $product->size }}</div>
                                <div class="font-bold text-pamsucolo-primary">₱{{ number_format($product->price,2) }}</div>
                                <div class="text-xs text-gray-500 break-words">{{ $product->short_description }}</div>
                            </div>
                            <form action="{{ route('admin.product.delete', $product) }}" method="POST" class="ml-4">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Loans Tab -->
        <div x-show="tab==='loans'">
            <h2 class="text-xl font-bold mb-4">Loan Requests</h2>
            <div class="space-y-6">
                @foreach($loans as $loan)
                <div class="bg-white rounded-xl shadow p-6 border flex flex-col md:flex-row md:items-center md:gap-4">
                    <div class="flex-1">
                        <div class="font-bold text-lg">Order #{{ $loan->order->id ?? 'N/A' }} • {{ $loan->order->created_at->format('M d, Y') ?? 'N/A' }}</div>
                        <div>For: <span class="text-gray-700 font-semibold">{{ $loan->user->student->first_name ?? 'N/A' }} {{ $loan->user->student->last_name ?? '' }}</span>
                            | Amount: <span class="text-pamsucolo-primary font-bold">₱{{ number_format($loan->amount,2) }}</span>
                        </div>
                        <div class="text-gray-600 text-sm">Reason: {{ $loan->note ?? '-' }}</div>
                        @if($loan->order)
                        <div class="text-gray-500 text-xs mt-1">Order Total: ₱{{ number_format($loan->order->total,2) }} | Items: {{ $loan->order->items->count() }}</div>
                        @endif
                    </div>
                    <div class="mt-2 md:mt-0">
                        <form action="{{ route('admin.loan.approve', $loan) }}" method="POST" class="inline">
                            @csrf
                            <button {{ $loan->status !== 'pending' ? 'disabled' : '' }} type="submit" class="py-1 px-3 bg-green-500 hover:bg-green-600 text-white rounded disabled:opacity-30">Approve</button>
                        </form>
                        <form action="{{ route('admin.loan.decline', $loan) }}" method="POST" class="inline">
                            @csrf
                            <button {{ $loan->status !== 'pending' ? 'disabled' : '' }} type="submit" class="py-1 px-3 bg-red-500 hover:bg-red-600 text-white rounded ml-2 disabled:opacity-30">Decline</button>
                        </form>
                        <div class="text-sm mt-2">
                            Status:
                            @if($loan->status=='pending')
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700">Pending</span>
                            @elseif($loan->status=='approved')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700">Approved</span>
                            @elseif($loan->status=='declined')
                                <span class="px-2 py-1 rounded bg-red-100 text-red-700">Declined</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Admin Account Tab -->
        <div x-show="tab==='account'">
            <div class="bg-white rounded-xl shadow p-6 max-w-sm mx-auto">
                <h2 class="text-xl font-bold mb-2">Admin Account</h2>
                <div class="mb-2">Name: <span class="font-semibold">Admin User</span></div>
                <div>Email: <span class="font-semibold">admin@pamsucolo.edu</span></div>
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="py-2 w-full px-4 rounded bg-gray-100 hover:bg-gray-200 text-pamsucolo-primary font-bold">Log Out</button>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

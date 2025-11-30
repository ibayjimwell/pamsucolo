@extends('layouts.app')
@section('content')
<main class="py-10 bg-pamsucolo-bg min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-pamsucolo-primary mb-8">My Account</h1>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-900 rounded p-4 text-sm">{{ session('success') }}</div>
        @endif

        <!-- Profile Info -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-2">Student Profile</h2>
            @if($student)
                <div class="grid grid-cols-2 gap-x-4">
                    <div><span class="font-medium text-gray-700">Full Name:</span> {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</div>
                    <div><span class="font-medium text-gray-700">Student No:</span> {{ $student->student_number }}</div>
                    <div><span class="font-medium text-gray-700">Email:</span> {{ $student->email }}</div>
                    <div><span class="font-medium text-gray-700">Campus:</span> {{ $student->current_campus }} | {{ $student->current_course }}</div>
                    <div><span class="font-medium text-gray-700">Year/Section:</span> {{ $student->current_year_level }} / {{ $student->current_section }}</div>
                </div>
            @else
                <div class="text-red-600 py-4">No linked student profile found. Please contact support.</div>
            @endif
        </div>

        <!-- Order History -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-2">Order History</h2>
            @if($orders->isEmpty())
                <p class="text-gray-600">No orders found.</p>
            @else
                @foreach($orders as $order)
                    <div class="mb-6 border-b last:border-b-0 pb-4 last:pb-0">
                        <div class="mb-1 font-bold text-pamsucolo-primary">Order #{{ $order->id }} &bull; {{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-600 mb-2">Total: ₱{{ number_format($order->total,2) }}</div>
                        <table class="w-full text-xs border mb-1">
                            <thead class="text-gray-700 bg-gray-50">
                                <tr>
                                    <th class="p-2">Product</th>
                                    <th class="p-2 text-center">Qty</th>
                                    <th class="p-2 text-right">Unit Price</th>
                                    <th class="p-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="p-2">{{ $item->product->name ?? 'Product deleted' }}</td>
                                        <td class="p-2 text-center">{{ $item->quantity }}</td>
                                        <td class="p-2 text-right">₱{{ number_format($item->price,2) }}</td>
                                        <td class="p-2 text-right">₱{{ number_format($item->quantity * $item->price,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-2">Loan Requests</h2>
            @if($loans->isEmpty())
                <p class="text-gray-600">No loan requests yet.</p>
            @else
                <table class="w-full text-left mb-4 text-sm">
                    <thead>
                        <tr class="font-bold bg-gray-100 text-gray-700">
                            <th class="py-2 px-2">Order</th>
                            <th class="py-2 px-2">Amount</th>
                            <th class="py-2 px-2">Note</th>
                            <th class="py-2 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td class="py-2 px-2">Order #{{ $loan->order->id ?? 'N/A' }} • {{ $loan->order->created_at->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="py-2 px-2">₱{{ number_format($loan->amount,2) }}</td>
                            <td class="py-2 px-2">{{ $loan->note ?? '-' }}</td>
                            <td class="py-2 px-2">
                                @if($loan->status=='pending')
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-600">Pending</span>
                                @elseif($loan->status=='approved')
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-700">Approved</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-700">Declined</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-2">Request a Loan</h2>
            <form action="{{ route('account.loan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700">Order</label>
                    <select name="order_id" id="order_id" required class="w-full border rounded mt-1 px-2 py-2" {{ $orders->isEmpty() ? 'disabled' : '' }} onchange="updateAmount(this)">
                        @if($orders->isEmpty())
                            <option value="">No orders found. Please make a purchase first.</option>
                        @else
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" data-amount="{{ $order->total }}">Order #{{ $order->id }} • {{ $order->created_at->format('M d, Y') }} (₱{{ number_format($order->total,2) }})</option>
                            @endforeach
                        @endif
                    </select>
                    @if($orders->isEmpty())
                        <p class="text-sm text-gray-500 mt-1">You need to make a purchase first before requesting a loan.</p>
                    @endif
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" min="1" step="0.01" name="amount" id="amount" required class="w-full border rounded mt-1 px-2 py-2 bg-gray-100" value="{{ $orders->first()->total ?? '' }}" readonly disabled>
                </div>
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700">Reason / Note</label>
                    <textarea name="note" id="note" rows="2" class="w-full border rounded mt-1 px-2 py-2">{{ old('note') }}</textarea>
                </div>
                <button type="submit" class="w-full py-2 rounded-lg bg-pamsucolo-primary text-white font-bold text-lg hover:bg-pamsucolo-primary/90 transition" {{ $orders->isEmpty() ? 'disabled' : '' }}>Submit Loan Request</button>
            </form>
        </div>
        <script>
            function updateAmount(select) {
                const amountInput = document.getElementById('amount');
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value) {
                    amountInput.value = selectedOption.getAttribute('data-amount');
                }
            }
            // Initialize amount on page load
            document.addEventListener('DOMContentLoaded', function() {
                const select = document.getElementById('order_id');
                if (select && select.options.length > 0 && select.options[0].value) {
                    updateAmount(select);
                }
            });
        </script>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-pamsucolo-primary underline text-sm">Log out</button>
        </form>
    </div>
</main>
@endsection

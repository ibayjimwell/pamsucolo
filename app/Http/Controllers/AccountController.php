<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Product;
use App\Models\Order;

class AccountController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    public function index() {
        $user = Auth::user();
        // Load student by student_number if relationship doesn't work
        $student = $user->student ?? \App\Models\Student::where('student_number', $user->student_number)->first();
        $loans = Loan::where('user_id', $user->id)->with('order.items.product')->latest()->get();
        $orders = Order::with('items.product')->where('user_id', $user->id)->latest()->get();
        return view('account', compact('user', 'student', 'loans', 'orders'));
    }
    public function requestLoan(Request $request) {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'note' => 'nullable|string',
        ]);
        $order = Order::findOrFail($request->order_id);
        // Verify order belongs to user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('account')->withErrors(['order_id' => 'Invalid order selected.']);
        }
        Loan::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'amount' => $order->total, // Auto-fill from order total
            'note' => $request->note,
            'status' => 'pending'
        ]);
        return redirect()->route('account')->with('success', 'Loan request submitted!');
    }
}

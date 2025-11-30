<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    public function index() {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('checkout', compact('cart'));
    }
    public function placeOrder(Request $request) {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        if($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error','Bag is empty!');
        }
        $total = 0;
        foreach($cart as $item) {
            $total += $item->quantity * $item->product->price;
        }
        $order = Order::create(['user_id'=>Auth::id(), 'total'=>$total]);
        foreach($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('account')->with('success','Order placed!');
    }
}

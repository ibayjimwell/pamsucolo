<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    public function index()
    {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('bag', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $item = CartItem::firstOrCreate(
            ['user_id'=>Auth::id(), 'product_id'=>$product->id],
            ['quantity'=>0]
        );
        $item->quantity += 1;
        $item->save();
        return redirect()->route('cart.index')->with('success','Product added to bag!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Check if cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate(['quantity'=>'required|integer|min:1']);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return redirect()->route('cart.index')->with('success','Quantity updated!');
    }

    public function remove(CartItem $cartItem)
    {
        // Check if cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success','Removed from bag!');
    }
}

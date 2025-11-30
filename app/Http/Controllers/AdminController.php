<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Loan;

class AdminController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    private function authorizeAdmin() {
        abort_unless(Auth::user() && Auth::user()->is_admin, 403);
    }
    public function dashboard() {
        $this->authorizeAdmin();
        $products = Product::all();
        $loans = Loan::with('user.student','order.items.product')->latest()->get();
        return view('admin', compact('products','loans'));
    }
    public function storeProduct(Request $request) {
        $this->authorizeAdmin();
        $fields = $request->validate([
            'name'=>'required', 'type'=>'required', 'image_url'=>'nullable',
            'size'=>'required', 'price'=>'required|numeric|min:0', 'short_description'=>'nullable'
        ]);
        Product::create($fields);
        return redirect()->route('admin.dashboard')->with('success','Product added!');
    }
    public function updateProduct(Request $request, Product $product) {
        $this->authorizeAdmin();
        $fields = $request->validate([
            'name'=>'required', 'type'=>'required', 'image_url'=>'nullable',
            'size'=>'required', 'price'=>'required|numeric|min:0', 'short_description'=>'nullable'
        ]);
        $product->update($fields);
        return redirect()->route('admin.dashboard')->with('success','Updated!');
    }
    public function destroyProduct(Product $product) {
        $this->authorizeAdmin();
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success','Product deleted!');
    }
    public function approveLoan(Loan $loan) {
        $this->authorizeAdmin();
        $loan->status = 'approved';
        $loan->save();
        return redirect()->route('admin.dashboard')->with('success','Loan approved!');
    }
    public function declineLoan(Loan $loan) {
        $this->authorizeAdmin();
        $loan->status = 'declined';
        $loan->save();
        return redirect()->route('admin.dashboard')->with('success','Loan declined.');
    }
}

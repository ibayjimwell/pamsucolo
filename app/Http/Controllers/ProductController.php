<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Show all products
        $products = Product::all();
        return view('shop', compact('products'));
    }
    public function show(Product $product)
    {
        return view('product_detail', compact('product'));
    }
    // Admin CRUD methods will go here.
}

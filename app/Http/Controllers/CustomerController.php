<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::latest()->take(6)->get();
        $newArrivals = Product::orderBy('created_at', 'desc')->take(5)->get();
        $bestSelling = Product::withCount('orderItems')
                        ->orderBy('order_items_count', 'desc')
                        ->take(5)
                        ->get();
                        
        return view('customer.index', compact('categories', 'featuredProducts', 'newArrivals', 'bestSelling'));
    }
}

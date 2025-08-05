<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function listProduct()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $products = Product::orderBy('id', 'desc')->with('category', 'subCategory')->get();
                // dd($products);
                return view('backend.admin.product.list', compact('products'));
            }
        }
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hotProduct = Product::where('product_type', 'hot')->orderBy('id', 'desc')->get();
        // dd($hotProduct);
        $newProduct = Product::where('product_type', 'new')->orderBy('id', 'desc')->get();
        $regularProduct = Product::where('product_type', 'regular')->orderBy('id', 'desc')->get();
        $discountProduct = Product::where('product_type', 'discount')->orderBy('id', 'desc')->get();
        return view ('frontend.index', compact('hotProduct','newProduct','regularProduct','discountProduct'));
    }

    public function shopProducts()
    {
        return view ('frontend.home.shop');
    }

    public function returnProducts()
    {
        return view ('frontend.home.return-process');
    }

    public function checkOut()
    {
        return view ('frontend.home.checkout');
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->with('color', 'size', 'galleryImage')->first();
        // dd($product);
        return view ('frontend.home.product-details',compact('product'));
    }
}

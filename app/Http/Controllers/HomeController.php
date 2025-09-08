<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
        return view('frontend.index', compact('hotProduct', 'newProduct', 'regularProduct', 'discountProduct'));
    }

    public function shopProducts()
    {
        return view('frontend.home.shop');
    }

    public function returnProducts()
    {
        return view('frontend.home.return-process');
    }

    public function checkOut()
    {
        return view('frontend.home.checkout');
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->with('color', 'size', 'galleryImage')->first();
        // dd($product);
        return view('frontend.home.product-details', compact('product'));
    }

    public function addtoCartDetails(Request $request, $id)
    {
        $cartProduct = Cart::where('product_id', $id)->where('ip_address', $request->ip())->first();
        // dd($cart);
        $product = Product::where('id', $id)->first();
        $action = $request->action;
        if ($cartProduct == null) {
            $cart = new Cart();
            $cart->product_id = $id;
            $cart->ip_address = $request->ip();
            $cart->qty = $request->qty;
            if ($product->discount_price != null) {
                $cart->price = $product->discount_price;
            } elseif ($product->discount_price == null) {
                $cart->price = $product->regular_price;
            }
            $cart->color = $request->color;
            $cart->size = $request->size;
            $cart->save();
            if ($action == 'addToCart') {
                toastr()->success('Added to cart');
                return redirect()->back();
            } else {
                toastr()->success('Added to cart');
                return redirect('/checkout');
            }
        } elseif ($cartProduct != null) {
            $cartProduct->qty = $cartProduct->qty + $request->qty;
            $cartProduct->save();
            if ($action == 'addToCart') {
                toastr()->success('Added to cart');
                return redirect()->back();
            } else {
                toastr()->success('Added to cart');
                return redirect('/checkout');
            }
        }
    }

    public function addtoCart(Request $request, $id)
    {
        $cartProduct = Cart::where('product_id', $id)->where('ip_address', $request->ip())->first();
        // dd($cart);
        $product = Product::where('id', $id)->first();
        if ($cartProduct == null) {
            $cart = new Cart();
            $cart->product_id = $id;
            $cart->ip_address = $request->ip();
            $cart->qty = 1;
            if ($product->discount_price != null) {
                $cart->price = $product->discount_price;
            } elseif ($product->discount_price == null) {
                $cart->price = $product->regular_price;
            }
            $cart->save();
            toastr()->success('Added to cart');
            return redirect()->back();
        } elseif ($cartProduct != null) {
            $cartProduct->qty = $cartProduct->qty + 1;
            $cartProduct->save();
            toastr()->success('Added to cart');
            return redirect()->back();
        }
    }
}

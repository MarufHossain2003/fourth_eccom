<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\RefundPolicy;
use App\Models\SubCategory;
use App\Models\TermsConditions;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hotProduct = Product::where('product_type', 'hot')->orderBy('id', 'desc')->get();
        $newProduct = Product::where('product_type', 'new')->orderBy('id', 'desc')->get();
        $regularProduct = Product::where('product_type', 'regular')->orderBy('id', 'desc')->get();
        $discountProduct = Product::where('product_type', 'discount')->orderBy('id', 'desc')->get();
        $homeBanner = HomeBanner::first();
        return view('frontend.index', compact('hotProduct', 'newProduct', 'regularProduct', 'discountProduct', 'homeBanner'));
    }

    public function shopProducts(Request $request)
    {
        if(isset($request->categoryId)){
            $type = 'category';
            $categoryProducts = Category::where('id', $request->categoryId)->with('product')->first();
            return view('frontend.home.shop', compact('categoryProducts', 'type'));
        }
        if(isset($request->subCategoryId)){
            $type = 'subCategory';
            $subCategoryProducts = SubCategory::where('id', $request->subCategoryId)->with('product')->first();
            return view('frontend.home.shop', compact('subCategoryProducts', 'type'));
        }
        $type = 'normal';
        $products = Product::orderBy('id', 'desc')->get();
        return view('frontend.home.shop', compact('products', 'type'));
    }

    public function productCart()
    {
        return view('frontend.home.view-cart');
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
        $product = Product::where('slug', $slug)->with('color', 'size', 'galleryImage', 'category')->first();
        // dd($product);
        // $addtoCart = Cart::where('ip_address', request()->ip())->get();
        // dd($addtoCart);
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

    public function deleteAddtoCart($id)
    {
        $cartProduct = Cart::find($id);
        $cartProduct->delete();
        return redirect()->back();
    }

    // confirm order
    public function confirmOrder(OrderRequest $request)
    {
        $order = new Order();

        $previousOrder = Order::orderBy('id', 'desc')->first();
        if($previousOrder == null){
            $order->invoiceId = 'AJBD-1';
        }
        if($previousOrder != null){
            $generateInvoiceId = 'AJBD-'.$previousOrder->id+1;
            $order->invoiceId = $generateInvoiceId;
        }
        $order->c_name  = $request->c_name;
        $order->c_phone = $request->c_phone;
        $order->email   = $request->email;
        $order->address = $request->address;
        $order->area    = $request->area;
        $order->price   = $request->inputGrandTotal;
        
        // Store Info into OrderDetails Table...
        $cartProducts = Cart::with('product')->where('ip_address', $request->ip())->get();
        if($cartProducts->isNotEmpty()){
            $order->save();
            foreach($cartProducts as $cart){
                $orderDetails = new OrderDetails();

                $orderDetails->order_id   = $order->id;
                $orderDetails->product_id = $cart->product_id;
                $orderDetails->qty        = $cart->qty;
                $orderDetails->price      = $cart->price;
                $orderDetails->size       = $cart->size;
                $orderDetails->color      = $cart->color;
                $orderDetails->save();
                $cart->delete();
            }
        }
        else{
            toastr()->warning('No product in cart!!');
            return redirect('/');
        }

        toastr()->success('Order Placed Successfully!!');
        return redirect('order-confirmed/'.$generateInvoiceId);
    }

    public function tahnkYouMessage($invoiceId)
    {
        return view('frontend.home.thankyou', compact('invoiceId'));
    }

    public function categoryProducts($slug)
    {
        $caegoryProducts = Category::where('slug', $slug)->with('product')->first();
        // dd($caegoryProducts);
        return view('frontend.home.category-products', compact('caegoryProducts'));
    }

    public function subCategoryProducts($slug)
    {
        $subCategoryProducts = SubCategory::where('slug', $slug)->with('product')->first();
        // dd($subCategoryProducts);
        return view('frontend.home.sub-category-products', compact('subCategoryProducts'));
    }

    // Search Products
    public function searchProducts(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->search.'%')->get();
        return view('frontend.home.search-products', compact('products'));
    }

    // Inner Pages
    public function privacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('frontend.home.privacy-policy', compact('privacyPolicy'));
    }
    
    public function termsConditions()
    {
        $termsConditions = TermsConditions::first();
        return view('frontend.home.terms-conditions', compact('termsConditions'));
    }

    public function refundPolicy()
    {
        $refundPolicy = RefundPolicy::first();
        return view('frontend.home.refund-policy', compact('refundPolicy'));
    }
    
    public function paymentPolicy()
    {
        $paymentPolicy = RefundPolicy::first();
        return view('frontend.home.payment-policy', compact('paymentPolicy'));
    }
}

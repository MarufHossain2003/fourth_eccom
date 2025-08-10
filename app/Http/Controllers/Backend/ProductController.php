<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function createProduct()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $categories = Category::orderBy('name', 'asc')->get();
                $subCategories = SubCategory::orderBy('name', 'asc')->get();
                return view('backend.admin.product.create', compact('categories', 'subCategories'));
            }
        }
    }

    public function storeProduct(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $product = new Product();
                if(isset($request->image)){
                    $imageName = rand().'-product-'.'.'.$request->image->extension();
                    $request->image->move('backend/images/product/', $imageName);
                    $product->image = $imageName;
                }

                $product->name = $request->name;
                $product->slug = Str::slug($request->name);
                $product->cat_id = $request->cat_id;
                $product->sub_cat_id = $request->sub_cat_id;
                $product->regular_price = $request->regular_price;
                $product->discount_price = $request->discount_price;
                $product->buy_price = $request->buy_price;
                $product->qty = $request->qty;
                $product->sku_code = $request->sku_code;
                $product->product_type = $request->product_type;
                $product->short_desc = $request->short_desc;
                $product->long_desc = $request->long_desc;
                $product->product_policy = $request->product_policy;

                $product->save();
                toastr()->success('Product Created Successfully');
                return redirect()->back();
            }
        }
    }
}


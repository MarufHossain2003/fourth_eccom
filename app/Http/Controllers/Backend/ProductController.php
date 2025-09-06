<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\GalleryImage;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function listProduct()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $products = Product::orderBy('id', 'desc')->with('category', 'subCategory')->get();
                // dd($products);
                return view('backend.admin.product.list', compact('products'));
            }
        }
    }

    public function createProduct()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $categories = Category::orderBy('name', 'asc')->get();
                $subCategories = SubCategory::orderBy('name', 'asc')->get();
                return view('backend.admin.product.create', compact('categories', 'subCategories'));
            }
        }
    }

    public function storeProduct(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $product = new Product();
                if (isset($request->image)) {
                    $imageName = rand() . '-product-' . '.' . $request->image->extension();
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

                // insert Product Color
                if (isset($request->color)) {
                    foreach ($request->color as $name) {
                        $clor = new Color();
                        $clor->product_id = $product->id;
                        $clor->color_name = $name;
                        $clor->save();
                    }
                }
                // insert Product Size
                if (isset($request->size)) {
                    foreach ($request->size as $name) {
                        $size = new Size();
                        $size->product_id = $product->id;
                        $size->size_name = $name;
                        $size->save();
                    }
                }

                // insert Gallery Image
                if (isset($request->galleryImage)) {
                    foreach ($request->galleryImage as $image) {
                        $galleryImage = new GalleryImage();
                        $galleryImage->product_id = $product->id;

                        $imageName = rand() . '-product-' . '.' . $image->extension();
                        $image->move('backend/images/galleryImage/', $imageName);
                        $galleryImage->image = $imageName;

                        $galleryImage->save();
                    }
                }
                toastr()->success('Product Created Successfully');
                return redirect()->back();
            }
        }
    }

    public function editProduct($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $categories = Category::orderBy('name', 'asc')->get();
                $subCategories = SubCategory::orderBy('name', 'asc')->get();
                $product = Product::where('id', $id)->with('color', 'size', 'galleryImage')->first();
                // dd($product);
                return view('backend.admin.product.edit', compact('product', 'categories', 'subCategories'));
            }
        }
    }

    public function updateProduct(Request $request, $id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $product = Product::find($id);

                if (isset($request->image)) {
                    if ($product->image && file_exists('backend/images/product/' . $product->image)) {
                        unlink('backend/images/product/' . $product->image);
                    }
                    $imageName = rand() . '-product-' . '.' . $request->image->extension();
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
                // $product->sku_code = $request->sku_code;
                $product->product_type = $request->product_type;
                $product->short_desc = $request->short_desc;
                $product->long_desc = $request->long_desc;
                $product->product_policy = $request->product_policy;

                $product->save();

                // insert Product Color
                if (isset($request->color)) {
                    $colors = Color::where('product_id', $product->id)->get();
                    foreach ($colors as $data) {
                        $data->delete();
                    }
                    foreach ($request->color as $name) {
                        $clor = new Color();
                        $clor->product_id = $product->id;
                        $clor->color_name = $name;
                        $clor->save();
                    }
                }
                // insert Product Size
                if (isset($request->size)) {
                    $size = Size::where('product_id', $product->id)->get();
                    foreach ($size as $data) {
                        $data->delete();
                    }
                    foreach ($request->size as $name) {
                        $size = new Size();
                        $size->product_id = $product->id;
                        $size->size_name = $name;
                        $size->save();
                    }
                }

                // insert Gallery Image
                if (isset($request->galleryImage)) {
                    $galleryImage = GalleryImage::where('product_id', $product->id)->get();
                    foreach ($galleryImage as $data) {
                        if ($data->data && file_exists('backend/images/galleryImage/' . $data->image)) {
                            unlink('backend/images/galleryImage/' . $data->image);
                        }
                        $data->delete();
                    }
                    foreach ($request->galleryImage as $image) {
                        $galleryImage = new GalleryImage();
                        $galleryImage->product_id = $product->id;

                        $imageName = rand() . '-product-' . '.' . $image->extension();
                        $image->move('backend/images/galleryImage/', $imageName);
                        $galleryImage->image = $imageName;

                        $galleryImage->save();
                    }
                }
                toastr()->success('Product Updated Successfully');
                return redirect()->back();
            }
        }
    }

    public function deleteProduct($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $product = Product::find($id);
                if ($product->image && file_exists('backend/images/product/' . $product->image)) {
                    unlink('backend/images/product/' . $product->image);
                }
                $colors = Color::where('product_id', $product->id)->get();
                if ($colors != null) {
                    foreach ($colors as $data) {
                        $data->delete();
                    }
                }

                $size = Size::where('product_id', $product->id)->get();
                if ($size != null) {
                    foreach ($size as $data) {
                        $data->delete();
                    }
                }

                $galleryImage = GalleryImage::where('product_id', $product->id)->get();
                foreach ($galleryImage as $data) {
                    if ($data->image && file_exists('backend/images/galleryImage/' . $data->image)) {
                        unlink('backend/images/galleryImage/' . $data->image);
                    }
                    $data->delete();
                }
                $product->delete();
                toastr()->success('Product Deleted Successfully');
                return redirect()->back();
            }
        }
    }
}

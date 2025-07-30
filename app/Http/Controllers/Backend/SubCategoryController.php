<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function listSubCategory()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $subCategories = SubCategory::get();
                return view('backend.admin.subcategory.list', compact('subCategories'));
            }
        }
    }

    public function createSubCategory()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $categories = Category::get();
                return view ('backend.admin.subcategory.create', compact('categories'));
            }
        }
    }

    public function storeSubCategory(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $subCategory = new SubCategory();
                $subCategory->cat_id = $request->cat_id;
                $subCategory->name = $request->name;
                $subCategory->slug = Str::slug($request->name);

                $subCategory->save();
                toastr()->success('Sub-Category created successfully!');
                return redirect('/admin/sub-category/list');
            }
        }
    }
}

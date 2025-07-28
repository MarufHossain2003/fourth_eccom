<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}

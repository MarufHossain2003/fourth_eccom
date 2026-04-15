<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function createCategory()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                return view('backend.admin.category.create');
            }
        }
    }

    public function storeCategory(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $category = new Category();
                $category->name = $request->name;
                $category->slug = Str::slug($request->name);
                if (isset($request->image)) {
                    $imageName = rand() . '-category-' . '.' . $request->image->extension();
                    $request->image->move('backend/images/category/', $imageName);
                    $category->image = $imageName;
                }
                $category->seo_title = $request->seo_title;
                $category->seo_description = $request->seo_description;
                $category->seo_keywords = $request->seo_keywords;
                $category->canonical_url = $request->canonical_url;

                $category->save();
                return redirect()->back();
            }
        }
    }

    public function listCategory()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $categories = Category::get();
                // dd($categories);
                return view('backend.admin.category.list', compact('categories'));
            }
        }
    }

    public function deleteCategory($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $category = Category::find($id);
                // dd($category);
                if ($category->image && file_exists('backend/images/category/' . $category->image)) {
                    unlink('backend/images/category/' . $category->image);
                }
                $category->delete();
                toastr()->warning('Category has been deleted successfully!');
                return redirect()->back()->with('success', 'Category deleted successfully');
            }
        }
    }

    public function editCategory($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $category = Category::find($id);
                // dd($category);
                return view('backend.admin.category.edit', compact('category'));
            }
        }
    }

    public function updateCategory(Request $request, $id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                $category = Category::find($id);
                $category->name = $request->name;
                $category->slug = Str::slug($request->name);

                if (isset($request->image)) {
                    if ($category->image && file_exists('backend/images/category/' . $category->image)) {
                        unlink('backend/images/category/' . $category->image);
                    }
                    $imageName = rand() . '-category-' . '.' . $request->image->extension();
                    $request->image->move('backend/images/category/', $imageName);
                    $category->image = $imageName;
                }

                $category->seo_title = $request->seo_title;
                $category->seo_description = $request->seo_description;
                $category->seo_keywords = $request->seo_keywords;
                $category->canonical_url = $request->canonical_url;

                $category->save();
                // composer require yoeunes/toastr (installed toastr for notifications)
                toastr()->success('Data has been saved successfully!');
                return redirect()->back();
            }
        }
    }

    // for SEO Controller
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}

<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',                             [HomeController::class, 'index']);
Route::get('/shop',                         [HomeController::class, 'shopProducts']);
Route::get('/return-process',               [HomeController::class, 'returnProducts']);
Route::get('/checkout',                     [HomeController::class, 'checkOut']);
Route::get('/product-details/{slug}',       [HomeController::class, 'productDetails']);

// Add to cart route
Route::post('/product/addtocart-details/{id}',              [HomeController::class, 'addtoCartDetails']);
Route::get('/product/addtocart/{id}',                       [HomeController::class, 'addtoCart']);

Auth::routes();

Route::get('/login',                        [AdminController::class, 'adminLogin']);
Route::post('/login-check',                 [AdminController::class, 'loginAccess']);
Route::get('/dashboard',                    [AdminController::class, 'adminDashboard']);

// Category Routes
Route::get('/admin/category/list',           [CategoryController::class, 'listCategory']);
Route::get('/admin/category/create',         [CategoryController::class, 'createCategory']);
Route::post('/admin/category/store',         [CategoryController::class, 'storeCategory']);
Route::get('/admin/category/delete/{id}',    [CategoryController::class, 'deleteCategory']);
Route::get('/admin/category/edit/{id}',      [CategoryController::class, 'editCategory']);
Route::post('/admin/category/update/{id}',   [CategoryController::class, 'updateCategory']);

// Sub Category Routes
Route::get('/admin/sub-category/list',              [SubCategoryController::class, 'listSubCategory']);
Route::get('/admin/sub-category/create',            [SubCategoryController::class, 'createSubCategory']);
Route::post('/admin/sub-category/store',            [SubCategoryController::class, 'storeSubCategory']);
Route::get('/admin/sub-category/delete/{id}',       [SubCategoryController::class, 'deleteSubCategory']);
Route::get('/admin/sub-category/edit/{id}',         [SubCategoryController::class, 'editSubCategory']);
Route::post('/admin/sub-category/update/{id}',      [SubCategoryController::class, 'updateSubCategory']);

// Product Routes
Route::get('/admin/product/list',              [ProductController::class, 'listProduct']);
Route::get('/admin/product/create',            [ProductController::class, 'createProduct']);
Route::post('/admin/product/store',            [ProductController::class, 'storeProduct']);
Route::get('/admin/product/delete/{id}',       [ProductController::class, 'deleteProduct']);
Route::get('/admin/product/edit/{id}',         [ProductController::class, 'editProduct']);
Route::post('/admin/product/update/{id}',      [ProductController::class, 'updateProduct']);
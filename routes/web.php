<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
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
Route::get('/product-details',              [HomeController::class, 'productDetails']);

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
Route::get('/admin/sub-category/list',              [SubCategoryController::class, 'listCategory']);
Route::get('/admin/sub-category/create',            [SubCategoryController::class, 'createCategory']);
Route::post('/admin/sub-category/store',            [SubCategoryController::class, 'storeCategory']);
Route::get('/admin/sub-category/delete/{id}',       [SubCategoryController::class, 'deleteCategory']);
Route::get('/admin/sub-category/edit/{id}',         [SubCategoryController::class, 'editCategory']);
Route::post('/admin/sub-category/update/{id}',      [SubCategoryController::class, 'updateCategory']);
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view ('frontend.index');
    }

    public function shopProducts()
    {
        return view ('frontend.home.shop');
    }

    public function returnProducts()
    {
        return view ('frontend.home.return-process');
    }
}

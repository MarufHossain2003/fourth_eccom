<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminLogin()
    {
        return view ('backend.admin.login');
    }

    public function loginAccess (Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email'=>$email, 'password'=>$password, 'role'=> 1])){
            return redirect ('/dashboard');
        }
    }

    public function adminDashboard()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                return view ('backend.admin.dashboard');
            }else{
                return redirect('/login');
            }
        }
    }
}

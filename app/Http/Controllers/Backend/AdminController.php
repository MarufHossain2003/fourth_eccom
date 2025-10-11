<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        if(Auth::attempt(['email'=>$email, 'password'=>$password, 'role'=> 2])){
            return redirect ('/dashboard');
        }
    }

    public function adminDashboard()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1 || Auth::user()->role == 2){
                $todayDate = Carbon::today();
                $totalOrders = Order::count();
                $todayOrders = Order::whereDate('created_at', $todayDate)->count();
                $pendingOrders = Order::where('status', 'pending')->count();
                $confirmedOrders = Order::where('status', 'confirmed')->count();
                $cancelledOrders = Order::where('status', 'cancelled')->count();
                $deliverededOrders = Order::where('status', 'delivered')->count();
                return view ('backend.admin.dashboard', compact('totalOrders', 'todayOrders', 'pendingOrders', 'confirmedOrders', 'cancelledOrders', 'deliverededOrders'));
            }else{
                return redirect('/login');
            }
        }
    }

    public function employeeList()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $employees = User::where('role', 2)->get();
                return view ('backend.admin.employee.list', compact('employees'));
            }
        }
    }

    public function employeeCreate()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                return view ('backend.admin.employee.create');
            }
        }
    }

    public function employeeStore(Request $request)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $employee = new User();

                if(isset($request->image)){
                    $imageName = rand().'-user-'.'.'.$request->image->extension();
                    $request->image->move('backend/images/user/', $imageName);
                    $employee->image = $imageName;
                }
                $employee->name     = $request->name;
                $employee->phone    = $request->phone;
                $employee->email    = $request->email;
                $employee->password = $request->password;
                $employee->address  = $request->address;
                $employee->role     = 2;
                $employee->save();
                toastr()->success('New employee has been added successfully!');
                return redirect('/admin/employee-list');
            }
        }
    }
}

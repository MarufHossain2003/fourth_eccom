<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function ShowAllOrders()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $allOrders = Order::with('orderDetails')->get();
                // dd($allOrders);
                return view ('backend.admin.orders.allorders', compact('allOrders'));
            }
        }
    }
    
    public function ShowPendingOrders()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $pendingOrders = Order::with('orderDetails')->where('status', 'pending')->get();
                // dd($allOrders);
                return view ('backend.admin.orders.pendingorders', compact('pendingOrders'));
            }
        }
    }
    
    public function ShowConfirmOrders()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $confirmedOrders = Order::with('orderDetails')->where('status', 'confirmed')->get();
                // dd($allOrders);
                return view ('backend.admin.orders.confirmedorders', compact('confirmedOrders'));
            }
        }
    }

    public function statusConfirmed ($id)
    {
       if(Auth::user()){
            if(Auth::user()->role == 1){
                $order = Order::find($id);
                $order->status = 'confirmed';
                $order->save();
                toastr()->success('Order has been confirmed!');
                return redirect()->back();
            }
        }
    }

    public function statusCancelled ($id)
    {
       if(Auth::user()){
            if(Auth::user()->role == 1){
                $order = Order::find($id);
                $order->status = 'cancelled';
                $order->save();
                toastr()->success('Order has been cancelled!');
                return redirect()->back();
            }
        }
    }

    public function statusDelivered ($id)
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $order = Order::find($id);

                if($order->courier_name != null){
                    $order->status = 'confirmed';
                    $order->save();
                    toastr()->success('Order has been delivered!');
                    return redirect()->back();
                }
                else{
                    toastr()->error('Please enter courier name first!');
                    return redirect()->back();
                }
            }
        }
    }

    public function ShowDeliveredOrders()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $deliveredOrders = Order::with('orderDetails')->where('status', 'delivered')->get();
                // dd($deliveredOrders);
                return view ('backend.admin.orders.deliveredorders', compact('deliveredOrders'));
            }
        }
    }

    public function ShowCancelledOrders()
    {
        if(Auth::user()){
            if(Auth::user()->role == 1){
                $cancelledOrders = Order::with('orderDetails')->where('status', 'cancelled')->get();
                // dd($cancelledOrders);
                return view ('backend.admin.orders.cancelledorders', compact('cancelledOrders'));
            }
        }
    }
}

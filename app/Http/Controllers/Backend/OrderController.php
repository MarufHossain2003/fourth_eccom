<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function ShowAllOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $allOrders = Order::with('orderDetails')->get();
                // dd($allOrders);
                return view('backend.admin.orders.allorders', compact('allOrders'));
            }
        }
    }

    public function ShowTodayOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $todayDate = Carbon::today();
                $todayOrders = Order::with('orderDetails')->whereDate('created_at', $todayDate)->get();
                // dd($allOrders);
                return view('backend.admin.orders.todayorders', compact('$todayOrders'));
            }
        }
    }
    
    public function ShowPendingOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $pendingOrders = Order::with('orderDetails')->where('status', 'pending')->get();
                // dd($allOrders);
                return view('backend.admin.orders.pendingorders', compact('pendingOrders'));
            }
        }
    }

    public function ShowConfirmOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $confirmedOrders = Order::with('orderDetails')->where('status', 'confirmed')->get();
                // dd($allOrders);
                return view('backend.admin.orders.confirmedorders', compact('confirmedOrders'));
            }
        }
    }

    public function statusConfirmed($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $order = Order::find($id);
                $order->status = 'confirmed';
                $order->save();
                toastr()->success('Order has been confirmed!');
                return redirect()->back();
            }
        }
    }

    public function statusCancelled($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $order = Order::find($id);
                $order->status = 'cancelled';
                $order->save();
                toastr()->success('Order has been cancelled!');
                return redirect()->back();
            }
        }
    }

    public function statusDelivered($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $order = Order::find($id);

                if ($order->courier_name != null) {
                    $order->status = 'delivered';

                    if($order->courier_name == "steadfast"){
                        // integrate steadfast api here
                        $endPoint = "https://portal.packzy.com/api/v1/create_order";
                        // Authentication Parameters
                        $apiKey = "";
                        $secrateKey = "";
                        // Body Parameters
                        $invoice = $order->invoice_id;
                        $customerName = $order->c_name;
                        $customerPhone = $order->c_phone;
                        $customerAddress = $order->address;
                        $price = $order->price;

                        // Header
                        $header = [
                            'Api-Key' => $apiKey,
                            'Secret-Key' => $secrateKey,
                            'Content-Type' => 'application/json',
                        ];
                        // Payload
                        $payload = [
                            'invoice' => $invoice,
                            'recipient_name' => $customerName,
                            'recipient_phone' => $customerPhone,
                            'recipient_address' => $customerAddress,
                            'cod_amount' => $price,
                        ];
                        $response = Http::withHeaders($header)->post($endPoint, $payload);
                        // dd($response->body());
                        $responsedata = $response->json();

                    }

                    // send email to customer if email id is available
                    // if($order->email != null){
                    //     Mail::to($order->email)->send(new OrderConfirmationMail($order));
                    // }
                    // send email to customer if email id is available
                    

                    $order->save();
                    toastr()->success('Order has been delivered!');
                    return redirect()->back();
                } else {
                    toastr()->error('Please enter courier name first!');
                    return redirect()->back();
                }
            }
        }
    }

    public function ShowDeliveredOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $deliveredOrders = Order::with('orderDetails')->where('status', 'delivered')->get();
                // dd($deliveredOrders);
                return view('backend.admin.orders.deliveredorders', compact('deliveredOrders'));
            }
        }
    }

    public function ShowCancelledOrders()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $cancelledOrders = Order::with('orderDetails')->where('status', 'cancelled')->get();
                // dd($cancelledOrders);
                return view('backend.admin.orders.cancelledorders', compact('cancelledOrders'));
            }
        }
    }

    public function orderDetails($id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $order = Order::where('id', $id)->with('orderDetails')->first();
                // dd($order);
                return view('backend.admin.orders.details', compact('order'));
            }
        }
    }

    public function orderUpdate(Request $request, $id)
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1 || Auth::user()->role == 2) {
                $order = Order::find($id);

                $order->c_name  = $request->c_name;
                $order->c_phone = $request->c_phone;
                $order->email   = $request->email;
                $order->address = $request->address;
                $order->price   = $request->price;

                if (isset($request->courier_name)) {
                    if ($request->courier_name == 'steadfast') {
                        $order->courier_name = 'steadfast';
                    }
                    if ($request->courier_name == 'others') {
                        $order->courier_name = $request->others_courier;
                    }

                    // send email to customer if email id is available

                    
                    // send email to customer if email id is available
                }

                $order->save();
                toastr()->success('Order is updated successfully!');
                return redirect()->back();
            }
        }
    }
}

@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Details Order</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {{-- <div class="row"> --}}
                <form action="{{url('/admin/orders/update/'.$order->id)}}" method="POST" class="form-control">
                    @csrf
                    <div class="row">
                        <div class="card col-md-6">
                            <div class="mt-3">
                                <label for="invoiceID">Invoice Number</label>
                                <input type="text" class="form-control" name="invoiceID" value="{{ $order->invoiceID }}"
                                    readonly><br>
                            </div>
                            <div>
                                <label for="c_name">Customer Name</label>
                                <input type="text" class="form-control" name="c_name" value="{{ $order->c_name }}"><br>
                            </div>
                            <div>
                                <label for="c_phone">Customer Phone Number</label>
                                <input type="text" class="form-control" name="c_phone" value="{{ $order->c_phone }}"><br>
                            </div>
                            <div>
                                <label for="email">Customer Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $order->email }}"><br>
                            </div>
                            <div>
                                <label for="address">Customer Address</label>
                                {{-- <input type="text" class="form-control" name="address" value="{{ $order->address }}"><br> --}}
                                <textarea name="address" id="" class="form-control">{{ $order->address }}</textarea>
                            </div>
                            <div class="mt-3">
                                <label for="area">Customer Area</label>
                                @php
                                    if ($order->area == 80) {
                                        $location = 'Inside Dhaka';
                                    } else {
                                        $location = 'Outside Dhaka';
                                    }
                                @endphp
                                <input type="text" class="form-control" name="area" value="{{ $location }}"
                                    readonly><br>
                            </div>
                            <div>
                                <label for="courier">Courier</label>
                                <select name="courier_name" id="courier_name" onchange="othersCourier()"
                                    class="form-control">
                                    <option selected disabled>Select Courier</option>
                                    <option value="steadfast"@if ($order->courier_name == "steadfast")
                                        selected
                                    @endif>Steadfast</option>
                                    <option value="others"@if ($order->courier_name != "steadfast" && $order->courier_name != null)
                                        selected
                                    @endif>Others</option>
                                </select>
                            </div>
                            @if ($order->courier_name != 'steadfast')
                                <div class="mt-3" id="others_courier">
                                <label for="others_courier">Others Courier</label>
                                <textarea name="others_courier" class="form-control">{{ $order->courier_name }}</textarea>
                            </div>
                            @else 
                            <div class="mt-3" style="display:none" id="others_courier">
                                <label for="others_courier">Others Courier</label>
                                <textarea name="others_courier" class="form-control">{{ $order->courier_name }}</textarea>
                            </div>
                            @endif
                        </div>
                        <div class="card col-md-6">
                            @foreach ($order->orderDetails as $details)
                                <div class="form-group mt-3">
                                    <img src="{{ asset('backend/images/product/' . $details->product->image) }}"
                                        alt="" height="75" width="75"><br>
                                    {{ $details->product->name }} <br>
                                    Quantity: {{ $details->qty }} <br>
                                </div>
                            @endforeach
                            <div class="form-group mt-3">
                                <label for="price">Order Price</label>
                                <input type="text" name="price" value="{{ $order->price }}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Update</button>
                        </div>
                    </div>
                </form>
                {{-- </div> --}}
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection

@push('script')
    <script>
        function othersCourier() {
            let courierName = document.getElementById('courier_name').value;
            if (courierName == 'others') {
                document.getElementById('others_courier').style.display = 'block';
            } else {
                document.getElementById('others_courier').style.display = 'none';
            }
        }
    </script>
@endpush

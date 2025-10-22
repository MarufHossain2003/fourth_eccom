@extends('frontend.master')
@section('content')
    <section class="return-process-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <form action="{{url('/return-product')}}" method="post" class="return-process-form form-group" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            <h3 class="return-process-form-title">Product Return Process</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-item-wrapper">
                                    <label for="c_name">Name</label>
                                    <input type="text" name="c_name" value="" placeholder="Name*"
                                        class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item-wrapper">
                                    <label for="c_phone">Phone</label>
                                    <input type="number" name="c_phone" value="" placeholder="Phone*"
                                        class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item-wrapper">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="" placeholder="Address*"
                                        class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item-wrapper">
                                    <label for="product_id">Order Id</label>
                                    <input type="text" name="product_id" value="" placeholder="Order Id*"
                                        class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-item-wrapper">
                                    <label for="c_email">Email Address</label>
                                    <input type="email" name="c_email" value="" placeholder="Enter your email"
                                        class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-item-wrapper">
                                    <label for="define_issue">Define issues</label>
                                    <textarea name="define_issue" cols="50" rows="5" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-item-wrapper">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="return-process-btn-outer">
                            <button type="submit" id="productReturnProcess" class="return-process-btn-inner">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

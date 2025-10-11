@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Credentials</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/credentials/update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $authUser->email }}" placeholder="Enter email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="text" class="form-control" id="old_password" name="old_password" placeholder="Enter old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                    </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('/admin/category/update/'.$category->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" value="{{$category->name}}" name="name" placeholder="Enter name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                        <img src="{{asset('backend/images/category/'.$category->image)}}" alt="Category Image" class="img-fluid mt-2"
                            style="width: 100px; height: 100px;">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

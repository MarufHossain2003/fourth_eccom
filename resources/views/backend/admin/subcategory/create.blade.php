@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Sub-Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/sub-category/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Select Category</label>
                        <select name="cat_id" class="form-control" id="cat_id">
                            <option selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Sub-Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                            required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

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
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Sub-Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <input type="text" class="form-control" id="seo_title" name="seo_title"
                            value="{{ old('seo_title', $subCategory->seo_title ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea class="form-control" id="seo_description" name="seo_description" rows="3">{{ old('seo_description', $subCategory->seo_description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="seo_keywords">SEO Keywords</label>
                        <input type="text" class="form-control" id="seo_keywords" name="seo_keywords"
                            value="{{ old('seo_keywords', $subCategory->seo_keywords ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="canonical_url">Canonical URL</label>
                        <input type="text" class="form-control" id="canonical_url" name="canonical_url"
                            value="{{ old('canonical_url', $subCategory->canonical_url ?? '') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

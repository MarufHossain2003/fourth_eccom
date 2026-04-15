@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/category/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image"
                                    accept="image/*" required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <input type="text" class="form-control" id="seo_title" name="seo_title"
                            value="{{ old('seo_title', $category->seo_title ?? '') }}">
                    </div>
                    {{--  --}}
                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea class="form-control" id="seo_description" name="seo_description" rows="3">{{ old('seo_description', $category->seo_description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="seo_keywords">SEO Keywords</label>
                        <input type="text" class="form-control" id="seo_keywords" name="seo_keywords"
                            value="{{ old('seo_keywords', $category->seo_keywords ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="canonical_url">Canonical URL</label>
                        <input type="text" class="form-control" id="canonical_url" name="canonical_url"
                            value="{{ old('canonical_url', $category->canonical_url ?? '') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

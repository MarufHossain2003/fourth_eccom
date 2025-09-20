@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/product/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="sku_code">SKU Code</label>
                        <input type="text" class="form-control" id="sku_code" name="sku_code"
                            placeholder="Enter SKU Code" required>
                    </div>
                    <div class="form-group">
                        <label for="cat_id">Select Category</label>
                        <select name="cat_id" id="cat_id" class="form-control">
                            <option selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_cat_id">Select SubCategory</label>
                        <select name="sub_cat_id" id="sub_cat_id" class="form-control">
                            <option selected disabled>Select Category</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="color_fields">
                        <label for="color">Product Color(optional)</label>
                        <input type="text" class="form-control" id="color" name="color[]"
                            placeholder="Enter Product Color">
                    </div>
                    <button type="button" class="btn btn-primary" id="add_color">Add More Color</button>
                    <div class="form-group" id="size_fields">
                        <label for="size">Product Size(optional)</label>
                        <input type="text" class="form-control" id="size" name="size[]"
                            placeholder="Enter Product Size">
                    </div>
                    <button type="button" class="btn btn-primary" id="add_size">Add More Size</button>
                    <div class="form-group">
                        <label for="qty">Product Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty"
                            placeholder="Enter Product Quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="buy_price">Buy Price</label>
                        <input type="text" class="form-control" id="buy_price" name="buy_price"
                            placeholder="Enter Buy Price" required>
                    </div>
                    <div class="form-group">
                        <label for="regular_price">Regular Price</label>
                        <input type="text" class="form-control" id="regular_price" name="regular_price"
                            placeholder="Enter Regular Price" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_price">Discount Price</label>
                        <input type="text" class="form-control" id="discount_price" name="discount_price"
                            placeholder="Enter Discount Price" required>
                    </div>
                    <div class="form-group">
                        <label for="product_type">Product Type</label>
                        <select name="product_type" id="product_type" class="form-control">
                            <option selected disabled>Select Category</option>
                            <option value="hot">Hot Product</option>
                            <option value="new">New Arrival</option>
                            <option value="regular">Regular Product</option>
                            <option value="discount">Discount Product</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="short_desc">Short Description</label>
                        <textarea id="summernote" name="short_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="long_desc">Long Description</label>
                        <textarea id="summernote2" name="long_desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_policy">Product Policy</label>
                        <textarea id="summernote3" name="product_policy"></textarea>
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
                        <label for="galleryImage">Gallery Image input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="galleryImage" multiple name="galleryImage[]"
                                    accept="image/*" required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        $(function() {
            // Summernote
            $('#summernote2').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        $(function() {
            // Summernote
            $('#summernote3').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    <script>
        // add more color field
        $(document).ready(function() {
            $("#add_color").click(function() {
                $("#color_fields").append(
                    `<div class="input-group mt-3 color-group">
                    <input type="text" class="form-control" name="color[]" placeholder="Enter Product Color" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-color">Remove</button>
                    </div>
                </div>`
                );
            });

            // Remove color field
            $("#color_fields").on("click", ".remove-color", function() {
                $(this).closest('.color-group').remove();
            });
        });
    </script>
    <script>
        // add more size field
        $(document).ready(function() {
            $("#add_size").click(function() {
                $("#size_fields").append(
                    `<div class="input-group mt-3 size-group">
                    <input type="text" class="form-control" name="size[]" placeholder="Enter Product Size" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-size">Remove</button>
                    </div>
                </div>`
                );
            });

            // Remove size field
            $("#size_fields").on("click", ".remove-size", function() {
                $(this).closest('.size-group').remove();
            });
        });
    </script>
@endpush

@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Refund Policy</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/refund-policy/update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="refundPolicy">Refund Policy</label>
                        <textarea id="summernote" name="refundPolicy">{{ $refundPolicy->description }}</textarea>
                    </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
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
    
@endpush

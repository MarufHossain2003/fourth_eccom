@extends('backend.master')
@section('content')
    <div class="col-md-12 mt-3">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Settings</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/admin/general-setting/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $settings->phone }}"
                            placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $settings->email }}" placeholder="Enter email"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="address" class="form-control" id="address" name="address" value="{{ $settings->address }}" placeholder="Enter address"
                            required>
                        {{-- <textarea id="summernote" name="address">{{ $settings->address }}</textarea> --}}
                    </div>
                
                <div class="form-group">
                    <label for="facebook">Facebook Link (Optional)</label>
                    <input type="text" class="form-control" id="facebook" value="{{ $settings->facebook }}" name="facebook"
                        placeholder="Enter facebook link" required>
                </div>
                <div class="form-group">
                    <label for="twitter">Twitter Link (Optional)</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $settings->twitter }}"
                        placeholder="Enter twitter link" required>
                </div>
                <div class="form-group">
                    <label for="linkedin">Linkedin Link (Optional)</label>
                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $settings->linkedin }}"
                        placeholder="Enter linkedin link" required>
                </div>
                <div class="form-group">
                    <label for="instagram">Instagram Link (Optional)</label>
                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $settings->instagram }}"
                        placeholder="Enter instagram link" required>
                </div>
                <div class="form-group">
                    <label for="youtube">Youtube Link (Optional)</label>
                    <input type="text" class="form-control" id="youtube" name="youtube" value="{{ $settings->youtube }}"
                        placeholder="Enter youtube link" required>
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                            <label class="custom-file-label" for="logo">Choose file</label>
                        </div>
                    </div>
                    <img src="{{asset('backend/images/settings/'.$settings->logo)}}" alt="logo" height="100" width="100">
                </div>
                <div class="form-group">
                    <label for="favicon">Favicon</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="favicon" name="favicon" accept="image/*">
                            <label class="custom-file-label" for="favicon">Choose file</label>
                        </div>
                    </div>
                    <img src="{{asset('backend/images/settings/'.$settings->favicon)}}" alt="favicon">
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

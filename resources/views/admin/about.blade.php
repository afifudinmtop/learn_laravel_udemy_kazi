@extends('admin/admin_master')
@section('admin')

<style>
    .apip_edit_profile{
        width: fit-content;
    }
</style>

<!-- TinyMCE -->
<script src="/tinymce.min.js" referrerpolicy="origin"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- error validation --}}
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger mb-3">
                                    <div>{{ $error }}</div>
                                </div>
                            @endforeach
                        @endif

                        {{-- success message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- error message --}}
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="/about_save" method="post" enctype="multipart/form-data">
                            @csrf
                            <h4 class="card-title">Edit About</h4>

                            {{-- title --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input value="{{$title}}" name="title" class="form-control" type="text" placeholder="Title">
                                </div>
                            </div>

                            {{-- sub_title --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Sub Title</label>
                                <div class="col-sm-10">
                                    <input value="{{$sub_title}}" name="sub_title" class="form-control" type="text" placeholder="Sub Title">
                                </div>
                            </div>
                            
                            {{-- caption --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Caption</label>
                                <div class="col-sm-10">
                                    <input value="{{$caption}}" name="caption" class="form-control" type="text" placeholder="Caption">
                                </div>
                            </div>

                            {{-- long_description --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Long Description</label>
                                <div class="col-sm-10">
                                    <div>
                                        <textarea id="tiny" name="long_description">{{$long_description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- image input --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                    <input id="image-upload" name="image" class="form-control" type="file" accept="image/*" />
                                    <img id="selected-image" src="/storage/about/{{$image}}" alt="avatar-5" class="mt-3 rounded avatar-lg" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info waves-effect waves-light mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputElement = document.getElementById("image-upload");
    const imgElement = document.getElementById("selected-image");

    inputElement.addEventListener("change", function() {
        // Get the selected file
        const file = inputElement.files[0];

        // Check if the selected file is an image
        if (file && file.type.startsWith("image/")) {
            // Read the file as a data URL
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                // Set the data URL as the source of the image element
                imgElement.src = reader.result;
            }
        }
    });
</script>

<script>
    tinymce.init({
      selector: 'textarea#tiny'
    });
  </script>
@endsection
@extends('admin/admin_master')
@section('admin')

<style>
    .apip_edit_profile{
        width: fit-content;
    }
</style>

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

                        <form action="/edit_profile" method="post" enctype="multipart/form-data">
                            @csrf
                            <h4 class="card-title">Edit Profile</h4>

                            {{-- username --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input value="{{$username}}" name="username" class="form-control" type="text" placeholder="Username">
                                    <input value="{{$user_id}}" name="user_id" class="d-none" type="text">
                                </div>
                            </div>

                            {{-- image input --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image</label>
                                <div class="col-sm-10">
                                    <input id="image-upload" name="image" class="form-control" type="file" accept="image/*" />
                                    <img id="selected-image" src="/storage/upload/{{$image}}" alt="avatar-5" class="mt-3 rounded avatar-lg" />
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
@endsection
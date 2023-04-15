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

                        <form action="/change_password" method="post">
                            @csrf
                            <h4 class="card-title">Change Password</h4>

                            {{-- old_password --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input name="old_password" class="form-control" type="password" placeholder="Old Password">
                                </div>
                            </div>

                            {{-- old_password --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input name="new_password" class="form-control" type="password" placeholder="New Password">
                                </div>
                            </div>

                            {{-- old_password --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input name="new_password_confirmation" class="form-control" type="password" placeholder="Confirm Password">
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
@endsection
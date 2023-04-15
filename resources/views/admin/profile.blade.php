@extends('admin/admin_master')
@section('admin')

<style>
    .apip_img{
        display:block;
        margin:auto;
    }
    .apip_edit_profile{
        width: fit-content;
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card p-3">
                    <img class="rounded-circle avatar-xl apip_img" alt="200x200" src="/storage/upload/{{$image}}" data-holder-rendered="true">
                    <div class="card-body p-0 my-3">
                        <h4 class="card-title">username : {{$username}}</h4>
                    </div>
                    <a href="/edit_profile">
                        <button type="button" class="apip_edit_profile btn btn-primary btn-rounded waves-effect waves-light">Edit Profile</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
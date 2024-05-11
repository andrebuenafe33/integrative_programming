@extends('admin.dashboard')
@section('content')

<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            <h2><i class="fa fa-solid fa-user"></i>Users Profile</h2>
        </div>
        <div class="card-body">
            <div id="profile_image" class="col-md-12 p-5 m-5" style="color: black; border-radius:50%;">
                ID HERE
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6>First Name:</h6>
                </div>
                <div class="col-md-12">
                    <h6>Middle Name:</h6>
                </div>
                <div class="col-md-12">
                    <h6>Last Name:</h6>
                </div>
                <div class="col-md-12">
                    <h6>Phone:</h6>
                </div>
                <div class="col-md-12">
                    <h6>Address:</h6>
                </div>
                <div class="col-md-12">
                    <h6>Email:</h6>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
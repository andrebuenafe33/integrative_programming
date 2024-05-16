@extends('admin.dashboard')
@section('content')

<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            <h2><i class="fa fa-solid fa-user"></i>Users Profile</h2>
        </div>
        <div class="card-body">
            <div id="profile_image" class="col-md-12 p-5 m-5" style="color: white; border-radius:25px; padding:20px; width:200px; background-color:black">
                ID HERE
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6>First Name: <strong>Andre</strong></h6>
                </div>
                <div class="col-md-12">
                    <h6>Middle Name:<strong>Gloria</strong></h6>
                </div>
                <div class="col-md-12">
                    <h6>Last Name:<strong>Buenafe</strong></h6>
                </div>
                <div class="col-md-12">
                    <h6>Phone:<strong>09107590281</strong></h6>
                </div>
                <div class="col-md-12">
                    <h6>Address:<strong>Brgy. Kangha-as Hilongos, Leyte</strong></h6>
                </div>
                <div class="col-md-12">
                    <h6>Email:<strong>admin@example.com</strong></h6>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
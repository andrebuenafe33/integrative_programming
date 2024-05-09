@extends('admin.dashboard')
@section('content')
    <div class="card mt-2">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h1><i class="fa fa-solid fa-users mt-2"></i> Users</h1>
                </div>
                <div class="col-md-6 col-12">
                    <a href="/users/create" class="float-end btn btn-primary mt-2"><i class="fa fa-solid fa-user"></i> Add
                        User</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-stripped table-column" id="UsersTable">
                    <caption>Users Table</caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Andre</td>
                            <td>Gloria</td>
                            <td>Buenafe</td>
                            <td>0910859029123123123</td>
                            <td>Brgy.Hilongos, Leyte</td>
                            <td>Admin@example.com</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="fa fas-solid fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm"><i class="fa fas-solid fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <script></script>
        </div>
    </div>

    <script>
        let table = new DataTable('#UsersTable');
    </script>
@endsection

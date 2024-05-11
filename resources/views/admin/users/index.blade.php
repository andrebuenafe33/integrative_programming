@extends('admin.dashboard')
@section('content')
    <div class="card mt-2">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h1><i class="fa fa-solid fa-users mt-2"></i> List of Users</h1>
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
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                       
                    </tbody>
                </table>
            </div>
            <script></script>
        </div>
    </div>

    <script>
        let table = new DataTable('#UsersTable');
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
    
    
        fetch('http://127.0.0.1:8000/api/user-list', {
            method: 'GET',
            headers:{
                Accept: 'application/json',
                Authorization: 'Bearer' + localStorage.getItem('token')
            },
        }).then((res)=>{
            console.log(res);
            return res.json();
        }).then(res => {
            console.log(res);
            for(var i=0; i< res.length; i++){
                var row = "<tr>" +
                        "<td>" + res[i].id + "</td>" +
                        "<td>" + res[i].first_name + "</td>" +
                        "<td>" + res[i].middle_name + "</td>" +
                        "<td>" + res[i].last_name + "</td>" +
                        "<td>" + res[i].address + "</td>" +
                        "<td>" + res[i].phone + "</td>" +
                        "<td>" + res[i].email + "</td>" +
                        "<td>" + 
                            "<a class='edit' title='Edit'><i class='fa fa-solid fa-edit'>Edit</i></a>" +
                            "<a class='delete' title='Delete' ><i class='fa fa-solid fa-trash'>Delete</i></a>" +
                        "</td>" +
                    "</tr>";
                    document.getElementById('usersTable').innerHTML += row;
            }
        })
        
    
    });

</script>

@endsection

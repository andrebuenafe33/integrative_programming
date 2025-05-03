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
            <div id="confirm-message" class="text-danger mb-3 hidden">
                This is Message!
            </div>
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
        </div>
    </div>

        {{-- Delete Confirmation Modal --}}
      <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"> Are you sure you want to delete this user?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm" id="confirmDelete">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    

<script>
     function getCurrentUser() {
            return fetch('http://127.0.0.1:8000/api/user', {
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then(res => res.json());
        }

    document.addEventListener('DOMContentLoaded', async function(){
        const currentUser = await getCurrentUser(); // Get logged-in user
       


        fetch('http://127.0.0.1:8000/api/userList', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: 'Bearer ' + localStorage.getItem('token')
            },
        }).then(res => res.json())
        .then(users => {
            for (let i = 0; i < users.length; i++) {
                if (users[i].id === currentUser.id) continue;

                const row = "<tr>" +
                    "<td>" + users[i].first_name + "</td>" +
                    "<td>" + users[i].middle_name + "</td>" +
                    "<td>" + users[i].last_name + "</td>" +
                    "<td>" + users[i].address + "</td>" +
                    "<td>" + users[i].phone + "</td>" +
                    "<td>" + users[i].email + "</td>" +
                    "<td>" +
                        `<a href="/users/${users[i].id}/edit" class='editUser btn btn-warning btn-sm' title='Edit Button'><i class='fa fa-solid fa-edit'></i> Edit</a> ` +
                        `<a class='deleteUser btn btn-danger btn-sm' data-user-id='${users[i].id}' title='Delete Button'><i class='fa fa-solid fa-trash'></i> Delete</a>` +
                    "</td>" +
                "</tr>";
                document.getElementById('usersTable').innerHTML += row;
            }
        })
        
        document.getElementById('usersTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('deleteUser')) { // mao ni kung mo loading na gani ang usersTable tapos naay contains deleteUser, means the button if mu reload ang page automatic ma detect niya ang button
                let userId = event.target.dataset.userId;
                $('#deleteConfirmationModal').modal('show');
                document.getElementById('confirmDelete').addEventListener('click', function() {
                    fetch(`http://127.0.0.1:8000/api/delete/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            console.log(data.message);
                            window.location.href = data.reload;
                        } else {
                            let errorMessage = document.getElementById('confirm-message');
                            errorMessage.innerHTML = data.message;
                            errorMessage.style.display = 'block';
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            }
        });
    
    });

</script>

@endsection

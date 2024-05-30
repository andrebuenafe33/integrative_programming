@extends('admin.dashboard')
@section('content')

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fa fa-user"></i> User Profile</h2>
            </div>
            <div>
                <a href="#" class="btn btn-light btn-sm" onclick="history.back()"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div id="profile_image" class="p-5 m-5 text-center" style="border-radius: 50%; background-color: #f0f0f0;">
                        <i class="fa fa-user fa-5x text-secondary"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="hidden" id="user_id" name="user_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>First Name:</strong> Andre</h6>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Middle Name:</strong> Gloria</h6>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Last Name:</strong> Buenafe</h6>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Phone:</strong> 09107590281</h6>
                        </div>
                        <div class="col-md-12">
                            <h6><strong>Address:</strong> Brgy. Kangha-as Hilongos, Leyte</h6>
                        </div>
                        <div class="col-md-12">
                            <h6><strong>Email:</strong> admin@example.com</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            let userId = getUserId();

                function fetchUserData(userId){
                    fetch('http://127.0.0.1:8000/api/users/' + userId)
                    .then(res => res.json())
                    .then(res => {
                        if(res.status){
                            let user = res.user;
                            document.getElementById('profile_image').src = user.profile_image;
                            document.getElementById('first_name').textContent = user.first_name;
                            document.getElementById('middle_name').textContent = user.middle_name;
                            document.getElementById('last_name').textContent = user.last_name;
                            document.getElementById('address').textContent = user.address;
                            document.getElementById('phone').textContent = user.phone;
                            document.getElementById('email').textContent = user.email;
                        } else {
                            console.error(res.message);
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                    });
                }

                // fetch user id
                if(userId){
                    fetchUserData(userId);
                }

            function getUserId(){
                let userId = document.getElementById('user_id').value = user.id;
                if(!userId){
                    let userId = localStorage.getItem('user_id');
                }
                if(!userId){
                    let messageDiv = document.getElementById('message');
                        messageDiv.innerHTML = console.log('User ID Not Found in Local Storage');
                        messageDiv.style.display = 'block';
                  
                }
                return userId;
            }
        });
</script>

@endsection
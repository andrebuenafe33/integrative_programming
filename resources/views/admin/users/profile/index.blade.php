@extends('admin.dashboard')
@section('content')

<style>
#profile_image {
    max-width: 250px; /* Set maximum width */
    max-height: 300px; /* Preserve aspect ratio */
}
</style>
<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fa fa-user"></i> User Profile</h2>
            </div>
            <div>
                <a href="/dashboard" class="btn btn-light btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-right"> <!-- Align content to the right -->
                        <img id="profile_image" class="profile-image" src="" alt="Profile Image" style="border-radius: 10%; background-color: #f0f0f0;">
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="hidden" id="user_id" name="user_id" value="5">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>First Name:</strong><h6 id="first_name"></h6>
                        </div>
                        <div class="col-md-6">
                            <strong>Middle Name:</strong><h6 id="middle_name"></h6>
                        </div>
                        <div class="col-md-6">
                            <strong>Last Name:</strong><h6 id="last_name"></h6>
                        </div>
                        <div class="col-md-6">
                            <strong>Phone:</strong><h6 id="phone"></h6>
                        </div>
                        <div class="col-md-12">
                            <strong>Address:</strong><h6 id="address"></h6>
                        </div>
                        <div class="col-md-12">
                            <strong>Email:</strong><h6 id="email"></h6>
                        </div>
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
                    fetch('http://127.0.0.1:8000/api/get/users/' + userId)
                    .then(res => res.json())
                    .then(res => {
                        if(res.status){
                            let user = res.user;

                            let profileImageElement = document.getElementById('profile_image');
                            profileImageElement.src = `/images/${user.profile_image}`;
                            profileImageElement.alt = `${user.first_name}'s Profile Image`;
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
                let userId = document.getElementById('user_id').value;
                if(!userId){
                    let userId = localStorage.getItem('user_id');
                }
                if(!userId){
                    console.log('User ID Not Found in Local Storage or In Input');
                  
                }
                return userId;
            }
             // Set user_id input value
            document.getElementById('user_id').value = getUserId();
        });
</script>

@endsection
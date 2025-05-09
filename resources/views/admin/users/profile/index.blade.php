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
                    <div class="text-right"> 
                        <a href="" data-lightbox="lightbox-img" id="profile-image" data-title="My Profile"> 
                            <img id="profile_image" class="profile-image" src="" alt="Profile Image" style="border-radius: 10%; background-color: #f0f0f0;">
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="hidden" id="user_id" name="user_id" value="1">
                    <div class="row">

                        <div class="col-md-6">
                            <strong>Role:</strong><h6 id="role"></h6>
                        </div>

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
            fetch('http://127.0.0.1:8000/api/user', {
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(user => {
                document.getElementById('role').textContent = user.role?.name ?? 'Unknown';
                document.getElementById('first_name').textContent = user.first_name;
                document.getElementById('middle_name').textContent = user.middle_name;
                document.getElementById('last_name').textContent = user.last_name;
                document.getElementById('address').textContent = user.address;
                document.getElementById('phone').textContent = user.phone;
                document.getElementById('email').textContent = user.email;

                let profileImageElement = document.getElementById('profile_image');
                profileImageElement.src = `/images/${user.profile_image}`;
                profileImageElement.alt = `${user.first_name}'s Profile Image`;
                document.getElementById('profile-image').href = `/images/${user.profile_image}`;
            })
            .catch(error => {
                console.error('Error fetching user:', error);
            });

        });
</script>

@endsection
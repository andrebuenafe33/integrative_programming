@extends('admin.dashboard')
@section('content')
    <div class="card mt-2">
        <div class="card-header">
            <h1><i class="fa fa-solid fa-user"></i>
                Edit User</h1>
        </div>
        <div class="card-body">
            <div id="message" class="text-danger mb-3 hidden">
                Edit Failed!
            </div>
            <form id="formData" class="users-form" enctype="multipart/form-data">
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="row">
                    <div class="form-group mb-2 col-md-6">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="dropify" id="profile_image" name="profile_image">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" 
                            value="{{ old('first_name') }}" placeholder="First Name...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" 
                            value="{{ old('middle_name') }}" placeholder="Middle Name...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" 
                            value="{{ old('last_name') }}" placeholder="Last Name...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" 
                            value="{{ old('address') }}" placeholder="Address...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                            value="{{ old('phone') }}" placeholder="Phone Number...">
                    </div>
                    <div class="form-group col-md-6">
                            <label for="inputEmail4">Course</label>
                            <select name="course" id="course" class="custom-select">
                                @if (isset($courses))
                                <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>Select Course</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="{{ old('email') }}" placeholder="Email...">
                    </div>
                     <div class="form-group col-md-6">
                            <label for="inputEmail4">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a Role</option>
                                <option value="1">Administrator</option>
                                <option value="2">Student</option>
                            </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                            placeholder="Password...">
                    </div> 
                </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success btn-sm" type="submit" value="Submit">Submit</button>
            <a href="/users" class="btn btn-secondary btn-sm">Cancel</a>
        </div>
        </form>
    </div>
    <script>
        document.getElementById('phone').addEventListener('input', function(event) {
            let input = event.target;
            let value = input.value;
            if (value.length > 11) {
                input.value = value.slice(0, 11); 
            }
        });    
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pathSegments = window.location.pathname.split('/');
            const userId = pathSegments[pathSegments.length - 2]; // Assuming URL is /users/{id}/edit

            fetchUserData(userId);

            // Update form submit
            document.querySelector('.users-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let formData = new FormData();

                // Spoof PUT method
                formData.append('_method', 'PUT');

                formData.append('firstname', document.getElementById('first_name').value);
                formData.append('middlename', document.getElementById('middle_name').value);
                formData.append('lastname', document.getElementById('last_name').value);
                formData.append('address', document.getElementById('address').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('role', document.getElementById('role').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('course', document.getElementById('course').value);
                formData.append('password', document.getElementById('password').value);

                let profileImageInput = document.getElementById('profile_image');
                if (profileImageInput.files.length > 0) {
                    formData.append('profile_image', profileImageInput.files[0]);
                }

                fetch('http://127.0.0.1:8000/api/update/users/' + userId, {
                    method: 'POST',
                    body: formData,
                    headers:{
                        Accept: 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')                    
                    },
                }).then(res => {
                    console.log(res);
                    return res.json();
                }).then (res => {
                    console.log(res);
                    if(res.status){
                        window.location.href = res.redirect;
                    } else {
                        let messageDiv = document.getElementById('message');
                        messageDiv.innerHTML = res.message;
                        messageDiv.style.display = 'block';
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            });

            function fetchUserData(userId) {
                fetch('http://127.0.0.1:8000/api/get/users/' + userId, {
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token') 
                    }    
                })
                .then(res => res.json())
                .then(res => {
                    if(res.status){
                        let user = res.user;
                        document.getElementById('user_id').value = user.id;
                        document.getElementById('first_name').value = user.first_name;
                        document.getElementById('middle_name').value = user.middle_name;
                        document.getElementById('last_name').value = user.last_name;
                        document.getElementById('address').value = user.address;
                        document.getElementById('phone').value = user.phone;
                        document.getElementById('role').value = user.role;
                        document.getElementById('email').value = user.email;
                        document.getElementById('course').value = user.course_id;
                    } else {
                        console.error(res.message);
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }


        });
    </script>
@endsection

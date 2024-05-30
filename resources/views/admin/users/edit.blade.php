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
            <form data="formData" class="users-form">
                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required
                            value="{{ old('first_name') }}" placeholder="First Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="middle_name">Middle Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" required
                            value="{{ old('middle_name') }}" placeholder="Middle Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required
                            value="{{ old('last_name') }}" placeholder="Last Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">Address <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" required
                            value="{{ old('address') }}" placeholder="Address...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone Number <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" required
                            value="{{ old('phone') }}" placeholder="Phone Number...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email <span class="red-required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="{{ old('email') }}" placeholder="Email...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password <span class="red-required">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="Password...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="dropify form-control" id="profile_image" name="profile_image">
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
        document.addEventListener('DOMContentLoaded', function() {
            let userId = getUserId();

                function fetchUserData(userId){
                    fetch('http://127.0.0.1:8000/api/users/' + userId)
                    .then(res => res.json())
                    .then(res => {
                        if(res.status){
                            let user = res.user;

                            document.getElementById('first_name').value = user.first_name;
                            document.getElementById('middle_name').value = user.middle_name;
                            document.getElementById('last_name').value = user.last_name;
                            document.getElementById('address').value = user.address;
                            document.getElementById('phone').value = user.phone;
                            document.getElementById('email').value = user.email;
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

                // form submit
            document.querySelector('.users-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let firstname = document.getElementById('first_name').value;
                let middlename = document.getElementById('middle_name').value;
                let lastname = document.getElementById('last_name').value;
                let address = document.getElementById('address').value;
                let phone = document.getElementById('phone').value;
                let email = document.getElementById('email').value;
                let password = document.getElementById('password').value;

                let formBody = {
                    firstname: firstname,
                    middlename: middlename,
                    lastname: lastname,
                    address: address,
                    phone: phone,
                    email: email,
                    password: password
                };

                fetch('http://127.0.0.1:8000/api/users/' + userId, {
                    method: 'PUT',
                    body: JSON.stringify(formBody),
                    headers:{
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')                    
                    },
                }).then(res => {
                    console.log(res);
                    return res.json();
                }).then (res => {
                    console.log(res);
                    if(res.status){
                        localStorage.setItem('token', res.token);
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

            function getUserId(){
                let userId = document.getElementById('user_id').value;
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

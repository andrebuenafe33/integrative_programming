@extends('admin.dashboard')
@section('content')
    <div class="card mt-2">
        <div class="card-header">
            <h1><i class="fa fa-solid fa-user"></i>
                Create New User</h1>
        </div>
        <div class="card-body">
            <div id="message" class="text-danger mb-3 hidden">
                Creation Failed!
            </div>
            <form data="formData" class="users-form" enctype="multipart/form-data">
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
            document.querySelector('.users-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let formData = new FormData();

                formData.append('firstname', document.getElementById('first_name').value);
                formData.append('middlename', document.getElementById('middle_name').value);
                formData.append('lastname', document.getElementById('last_name').value);
                formData.append('address', document.getElementById('address').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('password', document.getElementById('password').value);

                let profileImageInput = document.getElementById('profile_image');
                if (profileImageInput.files.length > 0) {
                    formData.append('profile_image', profileImageInput.files[0]);
                }

                fetch('http://127.0.0.1:8000/api/register', {
                    method: 'POST',
                    body:formData,
                    headers: {
                        Accept: 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    },

                }).then(res => {
                    console.log(res);
                    return res.json();
                }).then(res => {
                    console.log(res);
                    if (res.status) {
                        window.location.href = res.redirect;
                    } else {
                        let messageDiv = document.getElementById('message');
                        messageDiv.innerHtml = res.message;
                        messageDiv.style.display = 'block';
                    }
                })
            });
        })
    </script>
@endsection

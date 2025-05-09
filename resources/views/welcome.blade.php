<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Project UI</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('images/globe.ico') }}" type="image/x-icon">
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="antialiased">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-info" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Andre Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Login</a>
                    </li>
            </div> --}}
        </div>
    </nav>
    {{-- Login --}}
    <div class="container-xl" id="login-container">
        <div class="card col-md-4 mt-5" style="margin: 0 auto;" id="login-page">
            <form class="login-form">
                <div class="card-header">
                    <h1 class="text-center">
                        <li class="fa-solid fa-user me-2"></li>Login
                    </h1>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address<span
                                class="red-required">*</span></label>
                        <input type="email" class="form-control" name="email" id="email"
                            aria-describedby="emailHelp" placeholder="Enter Email Address">
                        <div class="required-message">This field is required!</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password<span class="red-required">*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                        <div class="required-message">This field required 8 characters!</div>
                    </div>
                    <div id="message" class="text-danger mb-3 hidden">
                        Invalid Credentials!
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Login</button>
                </div>
            </form>
        </div>
    </div>

    {{-- OTP Verification --}}
    <div class="container-sm hidden" id="otp-container">
        <div class="card col-md-4 mt-5" style="margin: 0 auto;">
            <div class="card-header">
                <h1 class="text-center">
                    <li class="fa-solid fa-user me-2"></li>Login
                </h1>
            </div>
            <div class="card-body">
                <h3 id="otpmessage">Enter OTP</h3>
                <form id="otp-form">
                    <div class="form-group">
                        <label for="otp_code" class="form-label">OTP<span class="red-required">*</span></label>
                        <input type="text" class="form-input" name="otp_code" id="otp_code" placeholder="Enter OTP Code" required>
                        <div class="required-message">This field is required!</div>
                    </div>
                    <div id="otp-message" class="text-danger mb-3 hidden">
                        Invalid OTP!
                    </div>
                    <button type="submit" class="btn-sm btn btn-primary cold-md-12 mt-2">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
    {{-- End of OTP Verification --}}

    <script>
        document.getElementById('otp_code').addEventListener('input', function(event) {
            let input = event.target;
            let value = input.value;
            if (value.length > 6) {
                input.value = value.slice(0, 6); 
            }
        });    
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.login-form').addEventListener('submit', function(event) {
                event.preventDefault();

                let email = document.getElementById('email').value
                let password = document.getElementById('password').value

                fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    body: JSON.stringify({
                        email: email,
                        password: password,
                    }),
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    },

                }).then(res => {
                    // if(!res.ok){
                    //     throw new Error('Network response was not okay');
                    // }
                    console.log(res);
                    return res.json();
                }).then(res => {
                    console.log(res);
                    if (res && res.status) {
                        localStorage.setItem('token', res.token);
                        document.getElementById('otp-container').style.display = 'block';
                        document.getElementById('login-container').style.display = 'none';
                        // window.location.href = res.redirect;
                        // console.log(res.mail);
                    } else {
                        let messageDiv = document.getElementById('message');
                        messageDiv.innerHTML = res.message || 'Unknown error';
                        messageDiv.style.display = 'block';
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            });

            document.getElementById('otp-form').addEventListener('submit', function(event){
                event.preventDefault();

                const formData = new FormData(this);
                const accessToken = localStorage.getItem('token');

                formData.append('token', accessToken); 

                fetch('http://127.0.0.1:8000/api/verifyOTP', {
                    method: 'POST',
                    body: formData,
                    headers:{
                        Accept: 'application/json',
                    }
                }).then(res => {
                    console.log(res);
                    return res.json();
                }).then(res => {
                    if(res.message == 'OTP Verified Successfully!'){
                        window.location.href = res.redirect;
                    } else {
                        let messageOTP = document.getElementById('otp-message');
                        messageOTP.innerHTML = res.message
                        messageOTP.style.display = 'block';
                    }
                })
            });
        })
    </script>
</body>

</html>

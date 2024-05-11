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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        const token = localStorage.getItem('token');
        if(!token){
          window.location.href = '/';
        }
        </script>
</head>

<body class="antialiased">
    {{-- <nav>
        <ul>
            <li><a href="#" id="users-link">Users</a></li>
            <li><a href="#" id="about-link">About</a></li>
        </ul>
    </nav>
    <aside>
        <ul>
            <li><a href="#" id="profile-link">Profile</a></li>
            <li><a href="#" id="settings-link">Settings</a></li>
            <li><a href="#" id="logout-link">Logout</a></li>
        </ul>
    </aside>
    <div class="container">
        <h1 id="page-title">Dashboard</h1>
        <div id="content">
            <!-- Content goes here -->
        </div>
    </div> --}}

    <nav class="navbar navbar-expand-lg bg-dark static-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" style="color: white">Andre Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <li class="nav-item dropdown no-arrow">

                <a class="nav-link dropdown-toggle" style="text-decoration: none; color:black;" href="#"
                    id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-white-900 small">Admin</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

    </nav>

    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fas fa-dashboard"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="/dashboard">Dashboard</a>
                </div>
            </div>

            <hr class="sidebar-divider">

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/users" class="sidebar-link">
                        <i class="fa fa-solid fa-user "></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>

        </aside>

        {{-- Content --}}
        <main class="container-fluid vh-100 pb-4 mb-2">
            @yield('content')
        </main>
        {{-- End of Content --}}
    </div>

    <div class="footer">
        <div class="rounded-top p-4">
            <div class="row">
                <div class="col-12 col-md-6 text-center text-sm-start mx-auto" style="color: white">
                    &copy; <a href="https://www.facebook.com/andre.buenafe.33/"><strong>Andre Website</strong></a>, All
                    Right Reserved
                    2024.
                </div>
            </div>
        </div>
    </div>

    @include('admin.users.partials._logout-modal')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        function logout(){
           localStorage.removeItem('token');
           window.location.href = '/'; 
       }
    </script>
       
</body>

</html>

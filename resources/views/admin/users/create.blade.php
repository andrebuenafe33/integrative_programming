@extends('admin.dashboard')
@section('content')
    <div class="card mt-2">
        <div class="card-header">
            <h1><i class="fa fa-solid fa-user"></i>
                Create New User</h1>
        </div>
        <div class="card-body">
            <form class="users-form">
                <div class="row">
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="first_name">First Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required
                            value="{{ old('first_name') }}" placeholder="First Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="middle_name">Middle Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" required
                            value="{{ old('middle_name') }}" placeholder="Middle Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="last_name">Last Name <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required
                            value="{{ old('last_name') }}" placeholder="Last Name...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="address">Address <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" required
                            value="{{ old('address') }}" placeholder="Address...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="phone">Phone Number <span class="red-required">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" required
                            value="{{ old('phone') }}" placeholder="Phone Number...">
                        <div class="required-message">This field is required.</div>
                    </div>
                    <div class="form-group mb-2 col-md-6 p-2">
                        <label for="email">Email <span class="red-required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="{{ old('email') }}" placeholder="Email...">
                        <div class="required-message">This field is required.</div>
                    </div>

                </div>
                <div class="form-group mb-2 col-md-6 p-2">
                    <label for="password">Password <span class="red-required">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="Password...">
                    <div class="required-message">This field is required.</div>
                </div>

        </div>
        <div class="card-footer">
            <button class="btn btn-success btn-sm" type="submit" value="Submit">Submit</button>
            <a href="/users" class="btn btn-secondary btn-sm">Cancel</a>
        </div>
        </form>
    </div>
@endsection

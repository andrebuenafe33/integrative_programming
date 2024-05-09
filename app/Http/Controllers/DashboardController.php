<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $userName = Auth::User()->first_name;


            Session::put('USERNAME', $userName);
        }

        return view('admin.dashboard');
    }
}

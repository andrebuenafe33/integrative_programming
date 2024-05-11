<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ], 401);

                // $user = User::where('email', $request->email)->first();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Logged In Successfully',
            //     'token' => $user->createToken("API TOKEN")->plainTextToken
            // ], 200);
            }
            $token = auth()->user()->createToken('/login');
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $token->accessToken,
                'redirect' => route('dashboard'), // this redirect to admin dashboard
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function createUser(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'middlename' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',


                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'middle_name' => $request->middlename,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),


            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

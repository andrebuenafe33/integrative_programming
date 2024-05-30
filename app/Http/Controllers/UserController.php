<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\UserSenderMail;

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
                    'message' => 'Invalid credentials!',
                ], 401);
            

            }
            $user = User::where('email', $request->email)->first();
                if(empty($user)){
                    return response()->json([
                        'message' => '404 not found',
                    ], 404);
                }
            if(!Hash::check($request->password, $user->password)){
                return response()->json([
                    'message' => 'Invalid Credentials!',
                ], 404);
                $code = rand(100000, 99999);
                $updateResult = $user->update([
                    'opt_code' => $code,
                ]);

                // Semaphore //
                // Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
                //     'apikey' => env('SEMAPHORE_API_KEY'),
                //     'number' => '09945364846',
                //     'message' => 'This is you OTP Code'.$code,
                // ]);
                // End of Semaphore // 

                if($updateResult){
                    return response()->json([
                        'status' => true,
                        'message' => 'OTP Sent Successfully!',
                        'code' => $code,
                        'token' => $user->createToken("API TOKEN")->plainTextToken,
                        'mail' =>  Mail::to('admin@example.com')->send(new UserSenderMail())  // Mailtrap Email // 
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to Send OTP',
                    ], 500);
                }
            }

            $token = auth()->user()->createToken('token');
            return response()->json([
                'status' => true,
                'message' => 'User Authenticated successfully',
                'token' => $token->accessToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $validateOTP = Validator::make($request->all(), [
                'otp_code' => 'required|digits:6'
            ]);

            if($validateOTP->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'errors' => $validateOTP->errors()
                ], 401);
            }

            $user = User::where('otp_code', $request->otp_code)->first();
            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP',
                ], 401);
            }

            $user->update(['otp_code' => null]);
            return response()->json([
                'status' => true,
                'message' => 'OTP Verified Successfully!',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'redirect' => route('dashboard')
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

    public function profile()
    {
        return view('admin.users.profile.index');
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
                    'message' => 'Create Failed!',
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
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'redirect' => route('users'),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validateUser = Validator::make(
                $request->all(),
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'middlename' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'password' => 'required',
                ]
            );

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Update Failed!',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user->update([
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
                'message' => 'User Updated Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'redirect' => route('dashboard'),
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
}

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
use Illuminate\Support\Facades\Log;
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
            // Log user retrieval and ID
            Log::info('User retrieved:', ['email' => $request->email, 'user_id' => $user->id]);

            if (empty($user)) {
                return response()->json([
                    'message' => '404 not found',
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credentials!',
                ], 401);
            }
           
            // Generate OTP and update the user
            $otp = rand(100000, 999999);
            $updateResult = $user->update([
                'otp_code' => $otp,
            ]);

            // Send OTP via Semaphore
            $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
                'apikey' => env('SEMAPHORE_API_KEY'),
                'number' => $user->phone, 
                'message' => 'This is your OTP Code: ' . $otp,
            ]);

            Log::info('Semaphore Response: ', $response->json());

            if ($response->successful()) {
                return response()->json([
                    'status' => true,
                    'message' => 'OTP Sent Successfully!',
                    'otp_code' => $otp,
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'number' => $user->phone,
                    'user' => $user
                    // 'mail' =>  Mail::to('andre@example.com')->send(new UserSenderMail())  // Mailtrap Email //
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Send OTP',
                ], 500);
            }
        } catch (\Throwable $th) {
            Log::error('Exception occurred during login:', ['message' => $th->getMessage()]);
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
                    'message' => 'Validation error',
                    'errors' => $validateOTP->errors()
                ], 401);
            }
    
           
            $user = User::where('otp_code', $request->otp_code)->first();
    
            if (!$user) {
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
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function profile()
    {
        // if(!auth()->check()){
        //     // return redirect()->route('home');
        //     return response(['error' => 'Unauthenticated!'], 401);
        // }

        // $user = auth()->user();

        // if(!user){
        //     return response(['error' => 'User Not Found!'], 404);
        // }

        // $token = $user->createToken("API TOKEN")->plainTextToken;

        return view('admin.users.profile.index');
    }

    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'middlename' => 'required|string|max:255',
                'address' => 'required|string',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'password' => 'required|string|min:6',
            ]);
    
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Create Failed!',
                    'errors' => $validateUser->errors()
                ], 422); // 422 is more appropriate for validation errors
            }
    
            // Handle profile image upload
            $filename = null;
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $filename);
            }
    
            // Create user
            $user = User::create([
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'middle_name' => $request->middlename,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'profile_image' => $filename,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'redirect' => route('users'),
                'user' => $user,
            ], 201); // 201 Created
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $th->getMessage()
            ], 500);
        }
    }
    

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
    
            $validateUser = Validator::make($request->all(), [
                'firstname' => 'nullable|string|max:255',
                'lastname' => 'nullable|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10048',
                'password' => 'nullable|string|min:6',
            ]);
    
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Update Failed!',
                    'errors' => $validateUser->errors()
                ], 422);
            }
    
            $updateData = [];
    
            if ($request->filled('firstname')) {
                $updateData['first_name'] = $request->firstname;
            }
    
            if ($request->filled('lastname')) {
                $updateData['last_name'] = $request->lastname;
            }
    
            if ($request->filled('middlename')) {
                $updateData['middle_name'] = $request->middlename;
            }
    
            if ($request->filled('address')) {
                $updateData['address'] = $request->address;
            }
    
            if ($request->filled('phone')) {
                $updateData['phone'] = $request->phone;
            }
    
            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }
    
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
    
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $filename);
    
                // Delete old image if exists
                if ($user->profile_image && file_exists(public_path('images/' . $user->profile_image))) {
                    unlink(public_path('images/' . $user->profile_image));
                }
    
                $updateData['profile_image'] = $filename;
            }
    
            // Apply updates
            $user->update($updateData);
    
            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully',
                'redirect' => route('users'),
                'user' => $user
            ], 200);
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    // // Handle profile image upload if there's a new image
    // $filename = $user->profile_image;
    // if ($request->hasFile('profile_image')) {
    //     $image = $request->file('profile_image');
    //     $filename = time() . '_' . $image->getClientOriginalName();
    //     $image->move(public_path('images'), $filename);
    //     // Delete old image if exists
    //     if ($user->profile_image) {
    //         // Check if the file exists before attempting to delete it
    //         if (file_exists(public_path('images/' . $user->profile_image))) {
    //             unlink(public_path('images/' . $user->profile_image));
    //         }
    //     }
    // }

    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function getUserById($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => true,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully!',
                'reload' => route('users')
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }   
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'middlename' => '',
            'lastname' => 'required',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }else {
            $user = User::create([
                'firstname'=>$request->firstname,
                'middlename'=>$request->middlename,
                'lastname'=>$request->lastname,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]); 

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status' =>200,
                'username' =>$user->firstname,
                'token' =>$token,
                'message' =>'Registered Successfully!',
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }else {
            $user = User::where('email', $request->email)->first();
 
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid Email or Password!',

                ]);
            }else {

                $token = $user->createToken($user->email.'_Token')->plainTextToken;

                return response()->json([
                    'status' =>200,
                    'username' =>$user->firstname,
                    'token' =>$token,
                    'message' =>'Logged In Successfully!',
                ]); 
            }
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' =>200,
            'message' =>'Logged Out Successfully!',
        ]); 
    }
}

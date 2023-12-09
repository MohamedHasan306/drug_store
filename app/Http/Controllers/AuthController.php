<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiTrait;

    public function register(Request $request){
        $validator=$request->validate([
            'name'=>'required|max:25|string',
            'email'=>'required|unique:users',
            'phone_number'=>'required|unique:users|max:10',
            'password'=>'required',

        ]);

        $user=User::create([
            'name'=> $validator['name'],
            'email'=> $validator['email'],
            'phone_number'=> $validator['phone_number'],
            'password'=> bcrypt($validator['password']),

        ]);

        $token = $user->createToken('myapp-token')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);

    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();
        return [
            'message'=>'logged out'
        ];

    }

    public function  login (Request $request){
        $validator=$request->validate([
            'phone_number'=>'required',
            'password'=>'required|max:10'
        ]);

        $user=User::where('phone_number',$validator['phone_number'])->first();
        if (! $user || ! Hash::check($validator['password'],$user->password) ){
            return response([
                'message'=> 'Bad creds',
                401
            ]);
        }

        $token = $user->createToken('myapp-token')->plainTextToken;


        $response=[
            'user'=>$user,
            'token'=>$token
        ];

        return response($response,201);
    }
}

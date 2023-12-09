<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
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
        $role=$user['role'];
        if ($role == 0){
            return response([
                'message'=>'you aren\'t admin',
                404
            ]);
        }

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
}

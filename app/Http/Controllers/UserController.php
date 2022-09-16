<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Contracts\Auth\Guard as AuthGuard;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Guid\Guid;
use Laravel\Sanctum\Guard;

class UserController extends Controller
{



    public function UserRegister(Request $request)
    {
        try {
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            if ($admin) {
                return response()->json($admin, 202);
            } else {
                return response()->json(['massage' => 'register failed '],202);
            }
        }catch (Exception $e){
            return response()->json($e , 401);
        }
    }



    public function Userlogin(Request $request){

            $credentials = $request->only([ 'email' ,'password' ]);
            // return $credentials;


        if(!$token = Auth()->guard('user-api')->attempt($credentials)){

            return response()->json(['massage' =>"Not Authenticated !!!"]);
            
        }
    
        return response()->json($token , 201);
        
    }



    public function me()
    {
        return response()->json(auth()->guard('user-api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Userlogout()
    {
        auth()->guard('user-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }





    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }

}

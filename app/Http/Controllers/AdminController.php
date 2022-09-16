<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Contracts\Auth\Guard as AuthGuard;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Guid\Guid;
use Laravel\Sanctum\Guard;

class AdminController extends Controller
{
    
    public function AdminRegister(Request $request)
    {
        try {
            $admin = Admin::create([
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



    public function AdminLogin(Request $request){

            $credentials = $request->only([ 'email' ,'password' ]);
            // return $credentials;


        if(!$token = Auth()->guard('admin-api')->attempt($credentials)){

            return response()->json(['massage' =>"Not Authenticated !!!"]);
            
        }
    
        return response()->json($token , 201);
        
    }



    public function me()
    {
        return response()->json(auth()->guard('admin-api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('admin-api')->logout();

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

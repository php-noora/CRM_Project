<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function UserRegister(Request $request)
    {
        try {

            $validateUser = validator::make($request->all(),
                [
                    'lastname' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'role'=>'required',

                ]
            );
            if ($validateUser->fails()) {
                return Response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validateUser->errors(),
                ], 404);
            }

            $Userr = User::create([
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=>$request->role,
            ]);
            $token = $Userr->createToken('api_token')->plainTextToken;


            return redirect()->route('workplace');
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

}
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('API TOKEN')->plainTextToken;
            return redirect()->route('workplace',['token' => $token]);

//            return response()->json([
//                'status' => true,
//                'message' => 'User Logged In Successfully',
//
//            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function logoutUser(request $request)
    {
        $request->user()->tokens()->delete();
        return view('authorize.login') ;
    }


}

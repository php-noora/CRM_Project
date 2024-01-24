<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.usersData', ['users' => $users]);
    }

    public function create()
    {
        return view('users.addUser');
    }

    public function store(UserRequest $request)

    {
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $users = User::find($id);
        return view('users.editUser', ['user' => $users]);
    }

    public function update(UserRequest $request, $id)
    {
        User::find($id)->update([
            'username' => $request->user_name,
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'phonenumber' => $request->phone_number,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'email' => $request->email,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);
        return redirect()->route('users.index');
    }


    public function destroy($id)
    {
        User::destroy($id);
        return back();
    }

    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'lastname' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                    'role' => 'required',
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            if ($request->role == 'seller') {
                $user = User::create([
                    'lastname' => $request->firstname,
                    'email' => $request->email,
                    'role' => $request->role,
                    'status' => 'enable',
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $user = User::create([
                    'lastname' => $request->firstname,
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                ]);
            }
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return redirect()->route('workplace');
//            return response()->json([
//                'status' => true,
//                'message' => 'User Created Successfully',
//                'token' => $token,
//            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function loginUser(LoginRequest $request)
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
                    'message' => 'validation error'
                    ,
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            dd($request);
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

    public function filter(request $request){
        $users= User::all();
        if($request->filterEmail){
            $users=$users->where('email',$request->filterEmail);
        }
        if($request->filterFirstName){
            $users = $users->where('firstname'.$request->filterFirstName);
        }
        if($request->filterLastName){
            $users= $users->where('lastname',$request->filterLastName);
        }
        if($request->filterUserName){
            $users = $users->where('username',$request->filterUserName);
        }
        if($request->filterPhoneNumber){
            $users = $users->where('phonenumber',$request->filterPhoneNumber);
        }
        if($request->filterAgeMin){
            $users = $users->where('age',$request->filterAgeMin);
        }
        if ($request->filterGender) {
            $users = $users->where('gender', $request->filterGender);
        }
        if ($request->filterPostalCode) {
            $users = $users->where('postal_code', $request->filterPostalCode);
        }
        $query = [];
        if ($request ->filterOrderStatus){
            if ($request->filterOrderStatus=='true'){
                foreach($users as $user){
                    if ($users->orders->count()){
                        $query[] =$users->id;
                    }
                }
            }
            if ($request->filterOrderStatus == 'false') {
                foreach ($users as $user) {
                    if (!$user->orders->count()) {
                        $query[] = $user->id;
                    }
                }
                $users = $users->find($query);
            }if($request->filterRole == '1'){
                $users = $users->where('role','customer');
            }
            if($request->filterRole == '2'){
                $users = $users->where('role','seller');
            }
            return view('users.usersData', ['users' => $users]);
        }

    }
}

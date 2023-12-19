<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        
        $validator=Validator::make($request->all() ,([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]));
       
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()]);
         }
        
           
        
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
       
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        // dd($request);
        $validator=Validator::make($request->all() ,([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'telephone' => ['required', 'regex:/^\+221(77|78|76|70)\d{7}$/','unique:users'],
            'adresse' => 'required|string|max:255',
            'role_id' => 'required'
        ]));
 if($validator->fails()){
    return response()->json(["error"=>$validator->errors()]);
 }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' =>$request->telephone,
            'adresse' =>  $request->adresse,
            'role_id' => $request->role_id
        ]);
    

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}

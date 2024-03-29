<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

      /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    //fetch all users from
    public function index() {
        $users = User::latest()->get();

        return response()->json([
            "message" => "Data fetch successfull",
            "data" => $users
        ],200);
    }

    //fetch single users from
    public function show($id) {
        $user = User::find($id);

        if($user){
            return response()->json([
                "success" => true,
                "message" => "Data fetched successfull",
                "data" => $user
            ],200);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Data not found!",

            ],200);
        }
    }
    //Delete user
    public function delete($id) {

        try{
             User::findOrFail($id)->delete();
            return response()->json([
                "success" => true,
                "message" => "User deleted successfully"
            ],200);
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => "User not deleted!"
            ],401);
        }
    }
    //Store user
    public function store(Request $request) {
         
        //ANOTHER VALIDATION PROCESS 
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6"
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ],401);
        }

        try{

           $data = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            return response()->json([
                "success" => true,
                "message" => "User created successfully",
                "data" => $data
            ],201);

        }catch(Exception $err){
            return response()->json([
                "success" => false,
                "errors" => $err
            ],401);
        }
       
    }

    //Update user
    public function update(Request $request,$id) {
         
        

        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6"
        ]);

        if($validator->fails()){
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ],401);
        }

        try{
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);


       
            return response()->json([
                "success" => true,
                "message" => "User updated successfully",
                "data" => $user
            ],200);

        }catch(Exception $err){
            return response()->json([
                "success" => false,
                "errors" => $err
            ],401);
        }
       
    }



    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

 
   protected function respondWithToken($token)
   {
       return response()->json([
           'access_token' => $token,
           'token_type' => 'bearer',
           'expires_in' => $this->guard()->factory()->getTTL() * 60
       ]);
   }

   /**
    * Get the guard to be used during authentication.
    *
    * @return \Illuminate\Contracts\Auth\Guard
    */
   public function guard()
   {
       return Auth::guard();
   }
}
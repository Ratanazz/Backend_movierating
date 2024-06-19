<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    public function register(Request $request) {
        // Validation
        $request->validate([
          "name" => "required|string",
          "email" => "required|string|email|unique:users",
          "password" => "required",
        ]);

        //user input
        User::create([
            "name" => $request->name,
          "email" => $request->email,
          "password" => bcrypt($request->password),
        ]);
        return response()->json([
            "status"=>true,
            "message"=>"user registered successfully",
        ]);
    }      
    public function login(Request $request) {
        // Validation
        $request->validate([
          "email" => "required|string|email",
          "password" => "required",
        ]);
      
        // Find user by email
        $user = User::where("email", $request->email)->first();
      
        // Check if user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
          // Generate and return token
          $token = $user->createToken("mytoken")->plainTextToken;
          return response()->json([
            "status" => true,
            "message" => "User login successful",
            "token" => $token,
            "data" => [],
          ]);
        } else {
          // Login failed - return appropriate message
          return response()->json([
            "status" => false,
            "message" => "Invalid credentials. Please try again.", // More specific message
            "data" => [],
          ]);
        }
      }
}

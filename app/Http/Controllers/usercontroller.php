<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\enroll;
use App\Models\admission;
use App\Models\course;

use App\Models\teacher;



class usercontroller extends Controller
{
    //
    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);
    
        if (User::where('email', $req->email)->first()) {
            return response([
                'message' => "User Already exists"
            ]);
        }
    
        // Handle image upload
        $imageName = time().'.'.$req->image->extension();
        $req->image->move(public_path('images'), $imageName);
    
        $encryptedPassword = Crypt::encryptString($req['password']);
    
        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => $encryptedPassword,
            'image' => $imageName, // Save image name in the database
             // Assuming 'message' field is available in your form
        ]);
    
        $token = $user->createToken($req->email)->plainTextToken;
    
        if ($user) {
            return response([
                'token' => $token,
                'message' => 'User Registered Successfully'
            ]);
        } else {
            return response([
                'message' => 'Internal Server Error'
            ]);
        }
    }





    // login code
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $req->email)->first();
    
        if ($user) {
            try {
                $decryptedPassword = Crypt::decryptString($user->password);
    
                if ($decryptedPassword === $req->password && $user->role == 0) {
                    $token = $user->createToken($req->email)->plainTextToken;
                    session()->put('user-id', $user->id);
                    return response([
                        "status" => 0,
                        "message" => "User Login Successfully",
                        "user_data" => [
                            "token" => $token,
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "image"=>$user->image
                            // "password" => $user->password
                        ]
                    ]);
                } else if ($decryptedPassword === $req->password && $user->role == 1) {
                    $token = $user->createToken($req->email)->plainTextToken;
                    session()->put('admin-id', $user->id);
                    return response([
                        "status" => 1,
                        "message" => "Admin Login Successfully",
                        "user_data" => [
                            "token" => $token,
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "image"=>$user->image
                            // "password" => $user->password
                        ]
                    ]);
                } else {
                    return response([
                        "message" => "User Login Failed"
                    ]);
                }
            } catch (\Exception $e) {
                return response([
                    "message" => "User Login Failed"
                ]);
            }
        } else {
            return response([
                "message" => "User Login Failed"
            ]);
        }
    }




    function update(Request $req){
      
        $user = User::where('email', $req->email)->first();
        if ($user) {
            $user->password = crypt::encryptString($req->password); // Assign hashed password
            $user->name = $req->name; // Assign new name
            $user->save(); // Save changes to the database
            return response([
                'name' => $req->name,
                'password' => $req->password, // You may not want to return password in response
                "message" => "Updated Successfully"
            ]);
        } else {
            return response([
                "message" => "User not found"
            ]);
        }
    }





    // get all users data
    public function get(){
$user = User::where('role', '0')->get();
echo $user;
// return response([
//     "data"=>$user,
//     "message"=>"All users data"
// ]);
    }



    // check status
    public function checkit($id) {
        $admi = admission::where('uid', $id)->with('user','course.teachers')->first();
        $enroll = enroll::where('uid', $id)->with('user','course.teachers')->first();
       
       
    
        if ($admi) {
            return response()->json([
                'message' => 'User successfully took admission',
                'status' => 1,
                'data' => $admi,
            ]);
        } elseif ($enroll) {
            return response()->json([
                'message' => 'Your Admission Is Still Pending',
                'status' => 2,
                'data' => $enroll,
            ]);
        } else {
            return response()->json([
                'message' => 'User Not Found',
                'status' => 0,
            ]);
        }
    }
    



    // log user data

    public function loguser(Request $req){
        $user = User::where('email', $req['email'])->first();

    if ($user) {
        $decryptedPassword = Crypt::decryptString($user->password);
        return response()->json([
            'data' => $decryptedPassword,
            'status' => 1,
        ]);
    } else {
        return response()->json([
            'message' => 'User not found',
            'status' => 0,
        ]);
    }

    }

    
}

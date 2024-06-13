<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\course;
use App\Models\User;
use App\Models\teacher;
use App\Models\enroll;
use App\Models\admission;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdmissionConfirmed;
use App\Mail\AdmissionDeletion;
use Illuminate\Support\Facades\Mail;


   class AdminController extends Controller
{

    // store course 
    function coursestore(Request $req){
        $req->validate([
           'cname'=>'required',
           'cdesc'=>'required',
           'cleng'=>'required',
        //    'cteach'=>'required',
           'ctime'=>'required',
           'camount'=>'required',
           'cstart'=>'required',
           'cend'=>'required',
           'image'=>'required|image' // Ensure the file is an image
        ]);
    
        // Create the course
        $course = Course::create([
            'cname' => $req['cname'],
            'cdesc' => $req['cdesc'],
            'cleng' => $req['cleng'],
            'tid' => $req['tid'],
            'ctime' => $req['ctime'],
            'camount' => $req['camount'],
            'cstart' => $req['cstart'],
            'cseat' => $req['cseat'], // Assuming 'cseat' is also a required field
            'cend' => $req['cend'],
        ]);
    
        // Handle the image upload
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $course->image = '/uploads/' . $imageName;
            $course->save();
        }
    
        return response()->json([
            'message' => 'Course created successfully',
            'status' => '200',
            'course' => $course
        ]);
    }
    

    
   
// Get all courses
function getcourse(){
    $courses = course::with('teachers')->get();
    return response()->json([
        'data' => $courses,
        'message' => 'Data sent successfully'
    ]);
}


// delete course
    function deletecourse($id){
   $course= course::find($id);
   if(!$course){
    return response()->json(['message' => 'Course not found'], 404);
   }else{
    $course->delete();
    return response()->json(['message' => 'Course deleted successfully']);
   }
    }





// course update
function courseupd($id){
    $course=course::with('teachers')->find($id);
    if(!$course){
        return response()->json(['message' => 'Course not found'], 404);
       }else{
        return response()->json(['message' => 'Course data get successfully','data'=>$course]);
       }
}

function courseedit($id, Request $req){
    $course=course::find($id);
    if(!$course){
        return response()->json(['message' => 'Course not found'], 404);
       }else{
        $req->validate([
            'cname'=>'required',
            'cdesc'=>'required',
            'cleng'=>'required',
            // 'tid'=>'required',
            'ctime'=>'required',
            'camount'=>'required',
            'cstart'=>'required',
            'cend'=>'required',
            'cseat'=>'required'
         ]);
         $course->cname=$req['cname'];
         $course->cdesc=$req['cdesc'];
         $course->cleng=$req['cleng'];
        //  $course->tid=$req['tid'];
         $course->ctime=$req['ctime'];
         $course->camount=$req['camount'];
         $course->cstart=$req['cstart'];
         $course->cend=$req['cend'];
         $course->cseat=$req['cseat'];
         $course->save();
         return response()->json([
            'data'=>$req['cname'],
            'message'=>"course updated successfully"
         ]);
       }
}



// del user
function deluser($id){
$user=User::find($id);
$user->delete();
}




// add teacher

function addteacher(Request $req){
    $req->validate([
'name'=>'required',
'email'=>'required',
'contact'=>'required',
// 'image'=>'required|image'
    ]);
    $teacher=teacher::create([
        'name'=>$req['name'],
        'email'=>$req['email'],
        'contact'=>$req['contact'],
        'address'=>$req['address'],
        'specialist'=>$req['specialist']
    ]);
  

    $teacher->save();
    if(  $teacher->save()){
        return response()->json([
            'message'=>'Data Stored Successfully'
        ]);
    }
}





// get all teacher

function getteacher(){
    $teacher=teacher::all();
    echo $teacher;
    
}


// delete Teacher
function deleteteacher($id,Request $req){
    $del=teacher::find($id);
    $del->delete();
    return response()->json([
        'message'=>'Deleted Successfully',
        'status'=>'ok'
    ]);
}



// get updateteacher data
function updateteacher($id,Request $req){
    $teach=teacher::find($id);
    if(!$teach){
        return response()->json([
            'message'=>'Data Not found'
        ]);
    }else{
        return response()->json(['message' => 'Course Find successfully','data'=>$teach]);
    }
}


// edit teacher now
function editteacher($id,Request $req){
    $teach=teacher::find($id);
    if(!$teach){
        return response()->json(['message' => 'Course not found'], 404);  
    }
    else{
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'contact'=>'required',
            'address'=>'required',
        ]);
        $teach->name=$req['name'];
        $teach->email=$req['email'];
        $teach->contact=$req['contact'];
        $teach->address=$req['address'];

        $teach->save();
        return response()->json(['message' => 'Teacher Updated Successfuly']);  
    }

}







// enroll course

function enrollcourse(Request $req){
    $req->validate([
        'cid'=>"required",
        'uid' => "required",
       
    ]);

    $id = $req['uid'];
    $check = enroll::where('uid',$id)->first();
    $adm=admission::where('uid',$id)->first();

    if($check>1){
        return response()->json([
            'message' => "You are already enrolled in the course",
            'status' => "error"
        ], 400);
    } else if($adm>1){
        return response()->json([
            'message' => "You are already eTake Admission in the course",
            'status' => "error"
        ], 400);
    }
     else {
        $enroll = enroll::create([
            'cid'=>$req['cid'],
            'uid' => $req['uid'],
         
        ]);

        return response()->json([
            'message' => "User Enrolled Successfully",
            'status' => "ok"
        ]);
    }
}




// user enroll data get

function getenroll($id){

// $enrolls = enroll::where('uid', $id)->with('user', 'course')->get();

$enrolls = Enroll::where('uid', $id)
    ->with(['user', 'course.teachers'])
    ->get();

if ($enrolls->isNotEmpty()) {
    return response()->json([
        'data' => $enrolls,
        'message' => 'Data retrieved successfully'
    ]);
} else {
    return response()->json([
        'message' => 'No enrollments found for the user'
    ], 404);
}


}





// delenroll user

function delenroll($id){
    $delenroll=enroll::where('uid',$id);
    $delenroll->delete();
    if($delenroll){
        return response()->json([
         'message'=>"Deleted Successfully",
         'status'=>'ok'
        ]);
    }else{
        return response()->json([
            'message'=>"Not Found",

           ]);    
    }
}




// get all enroll data

function getallenroll(Request $req){
    $enroll=enroll::all();
    echo $enroll;
}



public function specificenroll($id)
{
    // Fetch user along with their enrollments and courses
    // $user = User::with('enrollments.course.teachers')->find($id);
    $user = User::with('enrollments.course.teachers')->find($id);

    if ($user) {
        return response()->json([
            'user' => $user,
            'message' => 'Data retrieved successfully'
        ]);
    } else {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }
}

// delete specific enroll user
function delspecificenroll($id){
    $specific=enroll::where('uid',$id);
    $result=$specific->delete();
    if($result){
        return response()->json([
            'message'=>'Deleted Successfully',
            'status'=>'ok'
        ]);
    }else{
return response()->json([
    'message'=>'Not Foundii'
]);
    }
}




// move into admission table


function admission(Request $req)
{
    $req->validate([
        'cid' => "required",
        'uid' => "required",
    ]);

    // Fetch the course data
    $course = course::find($req['cid']);
    $enrol = enroll::where('uid', $req['uid'])->first(); // Ensure we get a single enrollment record

    if ($course && $course->cseat > 0) {
        // Create an admission record
        $admited = Admission::create([
            'cid' => $req['cid'],
            'uid' => $req['uid'],
        ]);

        if ($admited) {
            // Decrement cseat column by 1
            $course->decrement('cseat', 1);

            // Delete the enrollment record if it exists
            if ($enrol) {
                $enrol->delete();
            }

            // Fetch user details
            $user = $admited->user; // Assuming Admission has a relationship with User
            $course = $admited->course; // Assuming Admission has a relationship with Course

            // Send email
            Mail::to($user->email)->send(new AdmissionConfirmed($user, $course));

            return response()->json([
                'message' => 'Admission successful',
                'status' => 'ok',
                'admission' => $admited,
            ]);
        } else {
            return response()->json([
                'message' => 'Admission failed',
            ]);
        }
    } else {
        return response()->json([
            'message' => 'No seats available',
        ]);
    }
}

// get all admission list

public function getadmission(){
 $data=admission::with('user','course.teachers')->get();
 return response()->json([
    'data'=>$data,
    'message'=>'Admission Records are ........',
    'status'=>'ok'
 ]);
}




// delete admission


public function deleteadmission($id)
{
    $admission = Admission::find($id);

    if ($admission) {
        $user = $admission->user; // Assuming Admission has a relationship with User
        $course = $admission->course; // Assuming Admission has a relationship with Course

        // Delete the admission record
        $admission->delete();

        // Send email
        Mail::to($user->email)->send(new AdmissionDeletion($user, $course));

        return response()->json([
            'message' => 'Record deleted and email sent',
            'status' => 'ok'
        ]);
    } else {
        return response()->json([
            'message' => 'Record not found',
            'status' => 'error'
        ]);
    }
}


// find admission data
public function findadmission($id){
    $req=admission::find($id)->with('user','course.teachers')->first();
    if($req){
        return response()->json([
            'message'=>'Data is found',
            'data'=>$req,
        ]);
    }else{
        return response()->json([
            'message'=>'Data is not found',
            
        ]);
    }
}





// all enroll users

public function getallenrol(){
    $enrollCount = enroll::count();
    echo $enrollCount;
}

public function getalluser(){
    $enrolluser = User::count();
    echo $enrolluser;
}
public function getalladmission(){
    $admuser = admission::count();
    echo $admuser;
}
public function getallteacher(){
    $teacher = teacher::count();
    echo $teacher;
}
public function getallcourse(){
    $course = course::count();
    echo $course;
}





// updadmin

public function updadmin(Request $req){
    $req->validate([
        'name' => 'required',
        'password' => 'required'
    ]);
    $user = User::where('email', $req->email)->first();
    if ($user) {
        $user->password = Hash::make($req->password); // Assign hashed password
        $user->name = $req->name; // Assign new name
        $user->save(); // Save changes to the database
        return response([
            'name' => $req->name,
            'password' => $req->password, // You may not want to return password in response
            "message" => "Admin Updated Successfully"
        ]);
    } else {
        return response([
            "message" => "User not found"
        ]);
    }
}


}
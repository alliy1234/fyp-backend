<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\GoogleAuthController;


Route::post('/register',[usercontroller::class,'register']);
Route::post('/login',[usercontroller::class,'login']);
Route::post('/update',[usercontroller::class,'update']);
Route::get('/all',[usercontroller::class,'get']);
// Route::post('/adlogin',[usercontroller::class,'adlogin']);


// get login user data
Route::post('/loguser',[usercontroller::class,'loguser']);



// Admin start

Route::post('/course',[AdminController::class,'coursestore']);
Route::get('/allcourse',[AdminController::class,'getcourse']);
Route::delete('/coursedel/{id}',[AdminController::class,'deletecourse']);
Route::post('/courseup/{id}',[AdminController::class,'courseupd']);
Route::post('/courseedit/{id}',[AdminController::class,'courseedit']);
Route::delete('/deleteuser/{id}',[AdminController::class,'deluser']);
Route::post('/addteacher',[AdminController::class,'addteacher']);
Route::get('/getallteacher',[AdminController::class,'getteacher']);
Route::delete('/deleteteach/{id}',[AdminController::class,'deleteteacher']);
Route::post('/updateteach/{id}',[AdminController::class,'updateteacher']);
Route::post('/editteach/{id}',[AdminController::class,'editteacher']);
Route::get('/getallenrolldata',[AdminController::class,'getallenroll']);
Route::post('/specificenrolldata/{id}',[AdminController::class,'specificenroll']);
Route::delete('/delenroll/{id}',[AdminController::class,'delspecificenroll']);

Route::post('/updadmin',[AdminController::class,'updadmin']);

Route::post('/admissionstudent',[AdminController::class,'admission']);



// all dashbaor card list number
Route::get('/getallenroll',[AdminController::class,'getallenrol']);
Route::get('/getalluser',[AdminController::class,'getalluser']);
Route::get('/getalladmission',[AdminController::class,'getalladmission']);
Route::get('/getallteachers',[AdminController::class,'getallteacher']);
Route::get('/getallcourse',[AdminController::class,'getallcourse']);
Route::get('/getallnotification',[AdminController::class,'getallnotfication']);




// user workinmg
Route::post('/enrolluser',[AdminController::class,'enrollcourse']);
Route::post('/getenrolluser/{id}',[AdminController::class,'getenroll']);
Route::delete('/delenrolluser/{id}',[AdminController::class,'delenroll']);
// Get admission student data
Route::get('/getadmission',[AdminController::class,'getadmission']);
Route::delete('/deleteadmission/{id}',[AdminController::class,'deleteadmission']);
Route::post('/findadmission/{id}',[AdminController::class,'findadmission']);
Route::post('/stausadmission/{id}',[usercontroller::class,'checkit']);
Route::post('/notification',[AdminController::class,'notification']);
Route::get('/allnotification',[AdminController::class,'allnotification']);
Route::delete('/deletenotification/{id}',[AdminController::class,'deletenotification']);
Route::get('/updatenotification/{id}',[AdminController::class,'updatenotification']);
Route::post('/editenotification/{id}',[AdminController::class,'editenotification']);





// contact us
Route::post('/contact',[usercontroller::class,'contact']);
Route::get('/contactdata',[AdminController::class,'getcontact']);
Route::delete('/delete/{id}',[AdminController::class,'deletecontact']);


Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);




Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
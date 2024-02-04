<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebservicesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('StudentLogin',[WebservicesController::class,'StudentLogin'])->name('StudentLogin');
Route::post('myProfile',[WebservicesController::class,'myProfile'])->name('myProfile');
Route::post('student_register',[WebservicesController::class,'student_register'])->name('student_register');
Route::post('forgot_password',[WebservicesController::class,'forgot_password'])->name('forgot_password');
Route::post('changePassword',[WebservicesController::class,'changePassword'])->name('changePassword');
Route::post('edit_profile',[WebservicesController::class,'edit_profile'])->name('edit_profile');

Route::post('courseList',[WebservicesController::class,'courseList'])->name('courseList');
Route::post('subjectList',[WebservicesController::class,'subjectList'])->name('subjectList');
Route::post('chapterList',[WebservicesController::class,'chapterList'])->name('chapterList');
Route::post('questionList',[WebservicesController::class,'questionList'])->name('questionList');
Route::post('applyCourse',[WebservicesController::class,'applyCourse'])->name('applyCourse');
Route::post('myCourses',[WebservicesController::class,'myCourses'])->name('myCourses');
Route::post('myClasses',[WebservicesController::class,'myClasses'])->name('myClasses');


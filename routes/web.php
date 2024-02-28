<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[AuthController::class,'index']);
Route::post('login/auth',[AuthController::class,'auth'])->name('login.auth');
Route::get('registration',[AuthController::class,'registration']);
Route::post('registration_process',[AuthController::class,'registration_process'])->name('registration_process');
Route::get('/verification/{id}',[AuthController::class,'email_verification']);
Route::post('forgot_password',[AuthController::class,'forgot_password']);
Route::get('/forgot_password_change/{id}',[AuthController::class,'forgot_password_change']);
Route::post('forgot_password_change_process',[AuthController::class,'forgot_password_change_process']);

Route::group(['middleware'=>'admin_auth'],function(){
Route::get('admin/user',[UserController::class,'index']);
Route::get('admin/user/get_users',[UserController::class,'getUsers'])->name('admin.users.get_users');
Route::get('admin/user/status/{status}/{id}',[UserController::class,'status']);
Route::get('admin/user/delete/{id}',[UserController::class,'delete']);

});

Route::group(['middleware'=>'user_auth'],function(){
    Route::get('user/welcome',[FrontController::class,'index']);
    Route::get('profile/edit', [FrontController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [FrontController::class, 'update'])->name('profile.update');

});  

Route::get('logout', function () {
    session()->flush();
    session()->flash('','Logout sucessfully');
    return redirect('/');
});

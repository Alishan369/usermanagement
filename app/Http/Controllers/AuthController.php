<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Validator;

use Crypt;
use Mail;

class AuthController extends Controller
{
   public function index(Request $request)
   {
    if($request->session()->has('ADMIN_LOGIN')){
        return redirect('admin/user');
    }elseif ($request->session()->has('USER_LOGIN')) {
        return redirect('user/welcome');
    }else{
        return view('login');
    }
    return view('login');
   }
   public function auth(Request $request)
   {
       $email=$request->post('email');
       $password=$request->post('password');
       $result=users::where(['email'=>$email])->where('status',1)->first();
       if($result){
          $db_pwd=Crypt::decrypt($result->password);
           if($request->post('password') === $db_pwd){
            if ($result->role == 1) {
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result->id);
                return redirect('admin/user');
            }elseif($result->role == 0){
                $request->session()->put('USER_LOGIN',true);
               $request->session()->put('USER_ID',$result->id);
               $request->session()->put('NAME',$result->name);
               return redirect('user/welcome');
            }else {
                $request->session()->flash('error','something went wrong');
                return redirect('/');
            }
            }else{
               $request->session()->flash('error','Please enter correct password');
               return redirect('/');
           }
       }else{
           $request->session()->flash('error','Please enter valid login details');
           return redirect('/');
       }
   }

   public function registration(Request $request)
   {
       if($request->session()->has('USER_LOGIN')!=null){
        return redirect('user/welcome');
       }
       
       $result=[];
       return view('user.registration',$result);
   }

   public function registration_process(Request $request)
   {
      $valid=Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
       'password' => 'required|string|min:6',
       'mobile' => 'required|numeric|digits:10',
      ]);
      $chkEmail=users::where('email',$request->email)->first(); 
      if(!$valid->passes()){
           return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
      }else{
           $rand_id=rand(111111111,999999999);
           $arr=[
               "name"=>$request->name,
               "email"=>$request->email,
               "password"=>Crypt::encrypt($request->password),
               "number"=>$request->mobile,
               "status"=>1,
               "is_verify"=>0,
               "rand_id"=>$rand_id,
           ];
           $query=users::insert($arr);
           if($query){

               $data=['name'=>$request->name,'rand_id'=>$rand_id];
               $user['to']=$request->email;
               Mail::send('user/email_verification',$data,function($messages) use ($user){
                   $messages->to($user['to']);
                   $messages->subject('Email Id Verification');
               });

               return response()->json(['status'=>'success','msg'=>"Registration successfully. Please check your email id for verification"]);
           }

      }
   }

   public function email_verification(Request $request,$id)
   {
       $result=users::where(['rand_id'=>$id])
           ->where(['is_verify'=>0])
           ->get(); 

       if(isset($result[0])){
          users::where(['id'=>$result[0]->id])
           ->update(['is_verify'=>1,'rand_id'=>'']);
       return view('user.verification');
       }else{
           return redirect('/');
       }
   }

   
   public function forgot_password(Request $request)
   {
       
       $result=users::where(['email'=>$request->str_forgot_email])->get(); 
       $rand_id=rand(111111111,999999999);
       if(isset($result[0])){
        users::where(['email'=>$request->str_forgot_email])
               ->update(['is_forgot_password'=>1,'rand_id'=>$rand_id]);

           $data=['name'=>$result[0]->name,'rand_id'=>$rand_id];
           $user['to']=$request->str_forgot_email;
           Mail::send('user/forgot_email',$data,function($messages) use ($user){
               $messages->to($user['to']);
               $messages->subject("Forgot Password");
           });
           return response()->json(['status'=>'success','msg'=>'Please check your email for password']); 
       }else{
           return response()->json(['status'=>'error','msg'=>'Email id not registered']); 
       }
   }


   public function forgot_password_change(Request $request,$id)
   {
       $result=users::where(['rand_id'=>$id])
           ->where(['is_forgot_password'=>1])
           ->get(); 

       if(isset($result[0])){
           $request->session()->put('FORGOT_PASSWORD_USER_ID',$result[0]->id);
       
           return view('user.forgot_password_change');
       }else{
           return redirect('/');
       }
   }

   public function forgot_password_change_process(Request $request)
   {
       users::where(['id'=>$request->session()->get('FORGOT_PASSWORD_USER_ID')])
           ->update(
               [
                   'is_forgot_password'=>0,
                   'password'=>Crypt::encrypt($request->password)   ,
                   'rand_id'=>''
               ]
           ); 
       return response()->json(['status'=>'success','msg'=>'Password changed']);     
   }
}

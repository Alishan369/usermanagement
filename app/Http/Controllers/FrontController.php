<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Crypt;
use Mail;

class FrontController extends Controller
{
     public function index()
     {
        return view('user/home');
     }
     public function edit()
    {
        $userId = session('USER_ID');
        $user =  user::where('id',$userId)->where('status',1)->first();
        return view('user/edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = session('USER_ID');
        $user = User::where('id', $userId)->where('status', 1)->first();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'number' => 'required|numeric|digits:10',
        ]);
    
        $updateData = [
            'name' => $request->input('name'),
            'number' => $request->input('number'),
        ];
    
        // Check if the email is being updated
        if ($user->email != $request->input('email')) {
            $randId = rand(111111111, 999999999);
            $updateData['email'] = $request->input('email');
            $updateData['is_verify'] = 0;
            $updateData['rand_id'] = $randId;

            $data = ['name' => $request->name, 'rand_id' => $randId];
            $userEmail = $request->email;
    
            Mail::send('user.email_verification', $data, function ($message) use ($userEmail) {
                $message->to($userEmail);
                $message->subject('Email Id Verification');
            });
            $user->update($updateData);
            
            return response()->json(['status' => 'success', 'msg' => 'Registration successful. Please check your email for verification']);
        }
    
        $user->update($updateData);
        return response()->json(['status' => 'success', 'msg' => 'Profile updated successfully']);
    }
}

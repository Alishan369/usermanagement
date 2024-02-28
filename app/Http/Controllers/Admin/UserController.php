<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users;

class UserController extends Controller
{
    public function index()
    {
        return view('admin/user');
    }

    public function getUsers()
    {
        $users =  users::where('role','!=',1)->get();
        return response()->json(['data' => $users]);
    }
    public function status(Request $request,$status,$id)
    {
        $model=users::find($id);
        $model->status=$status;
        $model->save();
        if($status == 0){
            $msg ="User Blocked Successfully";
         }else{
             $msg ="User Unblocked Successfully";
         }
        return response()->json(['message' => $msg]);
    }
    public function delete(Request $request,$id){
        $model=users::find($id);
        $model->delete();
        return response()->json(['message' => 'User deleted Successfully']);
    }
}

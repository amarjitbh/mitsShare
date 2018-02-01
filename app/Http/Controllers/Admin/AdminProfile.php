<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\Admin\ChangePassword;
use Hash;
class AdminProfile extends Controller
{
    public function changePasswordView(){
        return view('admin.change_password');
    }

    /*===============================
        Function for Change Password
    =================================*/
    public function ChangeAdminPassword( ChangePassword $request ){
        try{
            $user = Auth::user();
            if(Hash::check($request->old_password, Auth::user()->password)){
                if(Hash::check($request->password, Auth::user()->password)){
                    return redirect('/change-password')->with('error', 'Sorry, Please choose different password.');
                } else {
                    $data['password'] = bcrypt( $request->password );
                    if( $user->update( $data ) ) {
                        return redirect('/change-password')->with('message', 'Password Updated successfully.');
                    } else {
                        return redirect('/change-password')->with('error', 'Sorry, Password can not be Changed.');
                    }
                }
            } else {
                return redirect('/change-password')->with('error', 'Old password is not correct.');
            }
        }catch(\Expection $e){
            echo $e->getMessage();
            die();
        }

    }
}

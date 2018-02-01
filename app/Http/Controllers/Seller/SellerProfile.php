<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ChangePassword;
use App\Http\Requests\Seller\EditProfile;
use Illuminate\Support\Facades\Input;
use Hash;
use Auth;

class SellerProfile extends Controller
{
    /*====================
        Load Profile View
    ======================*/
    public function myProfile(){
        $active = 'myProfile';
        return view('seller.my_profile', compact( 'active' ));
    }

    /*===============================
        Function For Editing Profile
    ==================================*/
    public function editProfile( EditProfile $request ) {
        $user = Auth::user();
        $data = $request->all();
        $data['first_name'] = $request->input( 'first_name');
        $data['last_name'] = $request->input( 'last_name') ;
        $data['mobile_number'] = $request->input( 'mobile_number') ;
        $data['about_me'] = $request->input( 'about_me') ;
        $img = Input::file('pic');
        if( $img != '' ) {
            $image	= $img->getClientOriginalName();
            $path 	= public_path(\Config::get('constants.IMAGE_FOLDER_NAME').DIRECTORY_SEPARATOR);
            $img->move($path,$image);
            $data['image'] = $image;
        }
        if( $user->update( $data ) ) {
            return redirect('/seller/my-profile')->with('message', 'Profile Updated successfully.');
        }
    }

    /*=============================
        Load Change Password View
    ===============================*/
    public function changePasswordView() {
        $active = 'changePassword';
        return view('seller.change_password', compact( 'active' ));
    }

    /*===============================
        Function for Change Password
    =================================*/
    public function changeSellerPassword( ChangePassword $request ){
        $user = Auth::user();
        if(Hash::check($request->old_password, Auth::user()->password)){
            if(Hash::check($request->password, Auth::user()->password)){
                return redirect('/seller/change-password-view')->with('error', 'Sorry, Please choose different password.');
            } else {
                $data['password'] = bcrypt( $request->password );
                if( $user->update( $data ) ) {
                    return redirect('/seller/change-password-view')->with('message', 'Password Updated successfully.');
                } else {
                    return redirect('/seller/change-password-view')->with('error', 'Sorry, Password can not be Changed.');
                }
            }
        } else {
            return redirect('/seller/change-password-view')->with('error', 'Old password is not correct.');
        }
    }
}

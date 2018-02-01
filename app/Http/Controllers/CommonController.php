<?php

namespace App\Http\Controllers;
use App\TemplateLog;
use App\User;
use App\PropertyReviews;
use App\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\UserRegistration;
use App\Http\Requests\Seller\PropertyReviewsRequest;
use Auth;
use DB;

class CommonController extends Controller
{
    /*** ===== Test function ======***/

    public function testval(Request $request){
        if($request->all()){
            pr($request->all());
            $rules = [
              'no1' => 'required',
              'jo2' => 'numeric',
            ];
            $this->validate($request,$rules);
        }
        return view('testval');
    }

    /***==== PROPERTY DETAIL ====***/
    public function index(){
        return view('Common.property_detail');
    }

    /***==== FORGOT PASSWORD ====***/
    public function forgotPassword() {
        return view('Common.forgot_password');
    }

    /***==== ABOUT US ====***/
    public function aboutUs() {
        return view('Common.about_us');
    }

    /***==== CONTACT US ====***/
    public function contactUs() {
        return view('Common.contact_us');
    }

    /***==== 404 NOT FOUND ====***/
    public function notFound404() {
        return view('Common.404');
    }

    /*=====================
        User Registration
    =======================*/
    protected function userRegister(UserRegistration $request) {
        $input = $request->all();
        $registration = User::create([
            'first_name'        => $input['first_name'],
            'last_name'         => $input['last_name'],
            'email'             => $input['email'],
            'registration_token' => md5(time()),
            'is_verified'       => 0,
            'role'              => 2,
            'password'          => bcrypt($input['password']),
            'mobile_number'     => $input['mobile_number'],
        ]);
        
        $message = array();
        $message['registration_token'] = $registration->registration_token;
        $message['email'] = $registration->email;
        $message['subject'] = "Email Verification";

        $templateLog = (new TemplateLog())->where(['template_log_id' => '1'])->first();
        $userName =  $input['first_name'].' '.$input['last_name'];
        $Link = "<a href=".route('verify.useremail').'?verify_link='.$message['registration_token'].">Click Here </a>";
        $messagee = $templateLog->message;
        $userTaskDes = array("#user_name#","#click_here#");
        $userTaskRep   = array($userName,$Link);
        $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messagee);
        $messageBody = $newTaskDes;
        //pr($messageBody,1);
        \Mail::send('email.email', array('body' => $messageBody), function($email) use ($message){
            $email->to($message['email'])->subject($message['subject']);
        });
        return redirect('/login')->with('message', 'You have been registered successfully. Please check your mail to verify the account.');
    }

    /*======================
        Verify User Profile 
    ========================*/
    public function verifyUserEmail(Request $request){
        /*$v = Validator::make($request->all(), [
            'verify_link' =>  'exists:users,is_verified',
        ],
            [
                'verify_link.exists' => 'Sorry, This email is already verified',
            ]
        );*/
        $input = $request->all();
        $user = User::where( array( 'registration_token' => $input['verify_link'],'is_verified' => '0') )->first();
        if(count($user) > 0) {

            if ($user->update(array('is_verified' => 1))) {
                return redirect('/login')->with('message', 'Your email is verified  successfully.');
            } else {
                return redirect('/login')->with('error', 'Something wend wrong.');
            }
        }else{
            Session::Flash('verify_link','Sorry, This email is already verified');
            return redirect('/login');
        }
    }

    /*========================
        Save Property Review
    ==========================*/
    public function savePropertyReview(PropertyReviewsRequest $request){
        $input = $request->all();
        if($input['commentType']==1){
            $ratingTo = Bookings::where(array('bookings.booking_id'=> $input['booking_id']))->value('property_owner_id');
        }
        if($input['commentType']==2){
            $ratingTo = Bookings::where(array('bookings.booking_id'=> $input['booking_id']))->value('user_id');
        }

        $data['property_id'] = $input['propertyid'];
        $data['rating_from_user'] = isset(Auth::user()->id) ? Auth::user()->id : '' ;
        $data['rating_to_user'] = $ratingTo;
        $data['rating'] = $input['rating'];
        $data['reason_for_rating'] = $input['reason_for_rating'];
        $data['comments'] = $input['comments'];
        $data['comment_type'] = $input['commentType'];
        $data['booking_id'] = $input['booking_id'];

        $propertyReviewsObj = new PropertyReviews($data);
        if($propertyReviewsObj->save()){
            return response()->json(['success'=>true, 'message' => 'Review is submitted successfully']);
        }else{
            return response()->json(['success'=>false]);
        }
    }
    /*=======================================
        Get All Reviews Of Property By Vikas
    ==========================================*/
    public function allReviewsOfProperty(Request $request){
        $input = $request->all();
        $propertyId = $input['propertyId'];
        $offset = isset($input['offset']) ? $input['offset'] : 0;
        $propertyReviews = (new PropertyReviews())->ajaxGetReviewOfBuyer( $propertyId, $offset );
        return response()->json($propertyReviews);
    }

    /*======================================
        Function For Reset Password By Link
    =======================================*/
    public function resetPasswordByLink(Request $request){
        $input = $request->all();
        $validation = Validator::make($input, [
            'email' =>  'exists:users,email',
        ],
            [
                'email.exists' => 'We can not find a user with that e-mail address.',
            ]
        );
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());
        }

        $token = User::where(array('email'=>$input['email']))->value('registration_token');
        DB::table('password_resets')->insert(
            ['email' => $input['email'], 'token' => $token]
        );
        $user = (new User())->where(['email' => $input['email']])->first();
        $message = array();
        $message['email'] = $input['email'];
        $message['subject'] = "Reset Password";
        $templateLog = (new TemplateLog())->where(['template_log_id' => '2'])->first();
        $userName =  $user->first_name.' '.$user->last_name;
        $Link = "<a href=".route('reset.password').'?token='.$token.">Click Here </a>";
        $messagee = $templateLog->message;
        $userTaskDes = array("#user_name#","#click_here#");
        $userTaskRep   = array($userName,$Link);
        $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messagee);
        $messageBody = $newTaskDes;
        \Mail::send('email.email', array('body' => $messageBody), function($email) use ($message){
            $email->to($message['email'])->subject($message['subject']);
        });
        return redirect()->back()->with('message', 'Please check your email to change the password');
    }


    /*========================================================
        Function For Loading the Form for Filling New Password
    ==========================================================*/
    public function changePasswordView(Request $request){
        $inputs = $request->all();
        $validation = Validator::make($inputs, [
            'token' =>  'exists:password_resets,token',
        ],
            [
                'token.exists' => 'This Link is expired.',
            ]
        );
        if($validation->fails()){
            return redirect('password/reset')->with('linkExists', 'This Link is expired.');//->back()->withErrors($validation->errors());
        }
        $token = $inputs['token'];
        return view('auth.passwords.reset',compact('token'));
    }

    /*=========================================
        Function For Change Password Final Step
    ===========================================*/
    public function resetPasswordFinalStep(Request $request){
        $inputs = $request->all();
        $email = User::where( array( 'registration_token' => $inputs['token'] ) )->value('email');
        $validation = Validator::make($inputs, [
            'token' =>  'exists:password_resets,token',
            'password' => 'required|min:12|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ],
            [
                'token.exists' => 'Token is not valid.',
                'password.regex' => 'Password should contain at least 1 number and 1 alphabet.',
            ]
        );
        if($validation->fails()){
            return redirect()->back()->withErrors($validation->errors());//->back()->withErrors($validation->errors());
        }
        DB::table('password_resets')->where(array('email' => $email))->delete(); // Delete token from Table
        $user = User::where( array( 'email' => $email ) )->first();
        $data['password']=bcrypt($inputs['password']);
        if($user->update( $data )){
            return redirect('login')->with('message', 'Your password is changed successfully');
        }
    }
}

<?php
namespace App\Http\Controllers;
use App\Bookings;
use App\PropertyFieldValue;
use App\TemplateLog;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\MessageToBeSend;
use DB;
use Auth;
use Session;
use Validator;
use Config;
use Mail;
class CronjobController extends Controller
{
    /*================================================
                Cronjob email fuction
    ==================================================*/
    public function index(){
        $mailList  = MessageToBeSend::where( array( 'is_send' => 1,'status' => 0) )->limit(10)->get()->toArray();
        foreach ($mailList as $key => $message) {
            $email = $message['email'];
            $messageBody = $message['body'];
            $subject = $message['subject'];
                Mail::send('email.email', array('body' => $messageBody), function($email) use ($message){ $email->to($message['email'])->subject($message['subject']); });
                if(MessageToBeSend::where('id', $message['id'])->update(array('status' => 1))){
                    echo "Done";
                }
        }
    }

    public function maiToNotAprovedProperty(){

        $utcCurrentTime = gmdate(date('Y-m-d H:i:s'));
        //echo $utcCurrentTime;
        //$timestamp = strtotime($utcCurrentTime) - 20*60;
        //$timestamp2 = strtotime($utcCurrentTime) - 10*60;
        $timestamp = strtotime($utcCurrentTime) - 300*120;
        $timestamp2 = strtotime($utcCurrentTime) - 270*120;

        $lastTime1 = date('Y-m-d H:i:s', $timestamp);
        $lastTime2 = date('Y-m-d H:i:s', $timestamp2);
        //echo '<br />'.$lastTime1;
        //echo '<br />'.$lastTime2;die;
        $messageData = [];
        $notApprovedData = (new Bookings())
                            ->join('booking_dates','booking_dates.booking_id','=','bookings.booking_id')
                            ->where(['is_approved' => '0','is_send' => '0'])
                            ->whereBetween('bookings.created_at', [$lastTime1,$lastTime2])
                            //->whereDate('bookings.created_at', '<', $utcCurrentTime)
                            //->whereDate('bookings.created_at', '<', $lastTime)
                            //->whereDate('booking_dates.date','>',date('Y-m-d'))
                            ->groupBy('bookings.booking_id')
                            ->get()->toArray();

        foreach($notApprovedData as $data) {

            $propertyName = (new PropertyFieldValue())->getPropertyDetail($data['property_id']);
            $propertyFullName = '';
            $routefunction = '<a href="' . route('pending-approval-booking-properties') . '">Click here</a>';
            foreach ($propertyName as $property) {
                if ($property['field_name'] == 'Name') {

                    $propertyFullName = $property['property_type_section_field_value'];
                }
            }
            $routefunction = '<a href="'.route('pending-approval-booking-properties').'">Click here</a>';
            $property_owner_details = User::where('id', $data['property_owner_id'])->first();
            $userName   = $property_owner_details['first_name'].' '.$property_owner_details['Last_name'];
            $templateLog = (new TemplateLog())->where(['template_log_id' => '7'])->first();
            $userTaskDes = array("#user_name#","#property_name#","#click_here#");
            $userTaskRep   = array($userName,$propertyFullName,$routefunction);
            $messages = $templateLog->message;
            $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
            $messageBody = $newTaskDes;
            $messageData[] = [

                'type'      => '1',
                'subject'   => 'Property Approval Reminder',
                'body'      => $messageBody,
                'email'     => $property_owner_details['email'],
                'mobile_no' => $property_owner_details['mobile_number'],
                'is_send'   => "1",
                'status'    => '0',
                'url'       => "/success",
            ];
            (new Bookings())->where(['booking_id' => $data['booking_id']])->update(['is_send' => '1']);
        }
        if(!empty($messageData)) {
            (new MessageToBeSend())->insert($messageData);
            echo 'done';
        }
    }
    /*  function ru after 16 hours of booking property  */
    public function maiToNotAprovedPropertySecond(){

        $utcCurrentTime = gmdate(date('Y-m-d H:i:s'));
        $timestamp = strtotime($utcCurrentTime) - 570*120;
        $timestamp2 = strtotime($utcCurrentTime) - 600*120;

        $lastTime1 = date('Y-m-d H:i:s', $timestamp);
        $lastTime2 = date('Y-m-d H:i:s', $timestamp2);

        //echo '<br />'.$utcCurrentTime;
        //echo '<br />'.$lastTime1;
        //echo '<br />'.$lastTime2;die;
        $messageData = [];
        $notApprovedData = (new Bookings())
                            ->join('booking_dates','booking_dates.booking_id','=','bookings.booking_id')
                            ->where(['is_approved' => '0','is_send' => '1'])
                            ->whereBetween('bookings.created_at', [$lastTime1,$lastTime2])
                            //->whereDate('bookings.created_at', '<', $utcCurrentTime)
                            //->whereDate('bookings.created_at', '<', $lastTime)
                            //->whereDate('booking_dates.date','>',date('Y-m-d'))
                            ->groupBy('bookings.booking_id')
                            ->get()->toArray();

        foreach($notApprovedData as $data) {

            $propertyName = (new PropertyFieldValue())->getPropertyDetail($data['property_id']);
            $propertyFullName = '';
            $routefunction = '<a href="' . route('pending-approval-booking-properties') . '">Click here</a>';
            foreach ($propertyName as $property) {
                if ($property['field_name'] == 'Name') {

                    $propertyFullName = $property['property_type_section_field_value'];
                }
            }
            $routefunction = '<a href="'.route('pending-approval-booking-properties').'">Click here</a>';
            $property_owner_details = User::where('id', $data['property_owner_id'])->first();
            $userName   = $property_owner_details['first_name'].' '.$property_owner_details['Last_name'];
            $templateLog = (new TemplateLog())->where(['template_log_id' => '7'])->first();
            $userTaskDes = array("#user_name#","#property_name#","#click_here#");
            $userTaskRep   = array($userName,$propertyFullName,$routefunction);
            $messages = $templateLog->message;
            $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
            $messageBody = $newTaskDes;
            $messageData[] = [

                'type'      => '1',
                'subject'   => 'Property Approval Reminder',
                'body'      => $messageBody,
                'email'     => $property_owner_details['email'],
                'mobile_no' => $property_owner_details['mobile_number'],
                'is_send'   => "1",
                'status'    => '0',
                'url'       => "/success",
            ];
            (new Bookings())->where(['booking_id' => $data['booking_id']])->update(['is_send' => '2']);

        }
        if(!empty($messageData)) {
            (new MessageToBeSend())->insert($messageData);
            echo 'done';
        }
    }

    /*  function run after 48 hours to approve property  */
    public function approvedPropertyMail(){

        $utcCurrentTime = gmdate(date('Y-m-d H:i:s'));
        //$timestamp = strtotime($utcCurrentTime) - 20*60;
        //$timestamp2 = strtotime($utcCurrentTime) - 10*60;
        //$lastTime1 = date('Y-m-d H:i:s', $timestamp);
        //$lastTime2 = date('Y-m-d H:i:s', $timestamp2);

        $lastTime1 =  date('Y-m-d H:i:s', strtotime($utcCurrentTime . " -48 hours"));
        $lastTime2 =  date('Y-m-d H:i:s', strtotime($utcCurrentTime . " -47 hours"));


        //echo '<br />'.$utcCurrentTime;
        //echo '<br />'.$lastTime1;
        //echo '<br />'.$lastTime2;
        $messageData = [];
        $notApprovedData = (new Bookings())
                            ->join('booking_dates','booking_dates.booking_id','=','bookings.booking_id')
                            ->where(['is_approved' => '1','payment_status' => '0'])
                            ->where('is_send','!=','3')
                            ->whereBetween('bookings.updated_at', [$lastTime1,$lastTime2])
                            //->whereDate('bookings.created_at', '<', $utcCurrentTime)
                            //->whereDate('bookings.created_at', '<', $lastTime)
                            //->whereDate('booking_dates.date','>',date('Y-m-d'))
                            ->groupBy('bookings.booking_id')
                            ->get()->toArray();
        //pr($notApprovedData);
        foreach($notApprovedData as $data) {

            $propertyName = (new PropertyFieldValue())->getPropertyDetail($data['property_id']);
            $propertyFullName = '';
            $routefunction = '<a href="' . route('approved-booking-properties',['id' => $data['booking_id']]) . '">Click here</a>';
            foreach ($propertyName as $property) {
                if ($property['field_name'] == 'Name') {

                    $propertyFullName = $property['property_type_section_field_value'];
                }
            }
            //$routefunction = '<a href="'.route('pending-approval-booking-properties').'">Click here</a>';
            $property_owner_details = User::where('id', $data['property_owner_id'])->first();
            $buyerDetail = User::where('id', $data['user_id'])->first();
            $userName   = $property_owner_details['first_name'].' '.$property_owner_details['Last_name'];
            $buyerName   = $buyerDetail['first_name'].' '.$buyerDetail['Last_name'];
            $templateLog = (new TemplateLog())->where(['template_log_id' => '8'])->first();
            $userTaskDes = array("#user_name#","#buyer_name#","#property_name#","#click_here#");
            $userTaskRep   = array($userName,$buyerName,$propertyFullName,$routefunction);
            $messages = $templateLog->message;
            $newTaskDes = str_replace($userTaskDes,$userTaskRep,$messages);
            $messageBody = $newTaskDes;
            $messageData[] = [

                'type'      => '1',
                'subject'   => 'Property Status Reminder',
                'body'      => $messageBody,
                'email'     => $property_owner_details['email'],
                'mobile_no' => $property_owner_details['mobile_number'],
                'is_send'   => "1",
                'status'    => '0',
                'url'       => "/success",
            ];
            (new Bookings())->where(['booking_id' => $data['booking_id']])->update(['is_send' => '3']);

        }
        if(!empty($messageData)) {
            (new MessageToBeSend())->insert($messageData);
            echo 'done';
        }
    }
    
}

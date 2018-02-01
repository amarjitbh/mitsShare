<?php

use Illuminate\Database\Seeder;

class TemplateLogEmailSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('template_logs')->truncate();
        DB::table('template_logs')->insert([
                [
                        'action_id' => '1',
                        'type'=>'1',
                        'tags'=>'#user_name#,#click_here#',
                        'message'=>'Dear #user_name# ,<br /><br />
                            Thank your for registering with shareAir. To verify your account, please click on the following link.
                            <br /><br />#click_here# to verify your email.
                            <br /><br />
                            Regards,<br />
                            ShareAir Team',
                        'created_at' => date('Y-m-d h:i:s'),
                ],[
                        'action_id' => '1',
                        'type'=>'1',
                        'tags'=>'#user_name#,#click_here#',
                        'message'=>"Dear #user_name# ,<br /><br />
                            A password reset was requested for your account. Please click on the link below to reset your password. If you didn't make this request, ignore this email.
                            <br /><br />#click_here# to reset you password.<br /><br />
                            ",
                        'created_at' => date('Y-m-d h:i:s'),
                ],[
                        'action_id' => '1',
                        'type'=>'1',
                        'tags'=>'#user_name#,#click_here#',
                        'message'=>"Dear #user_name# ,<br /><br />
                            #buyer_name# has requested to book #property_name# from #from_date# to #end_date#. <br /> #click_here# to accept/reject this request.
                            <br /><br />
                            Regards,<br />
                            ShareAir Team" ,
                        'created_at' => date('Y-m-d h:i:s'),
                ],[
                        'action_id' => '1',
                        'type'=>'1',
                        'tags'=>'#user_name#,#click_here#',
                        'message'=>"Dear #user_name# ,<br /><br />
                           #messages#
                            Regards,<br />
                            ShareAir Team",
                        'created_at' => date('Y-m-d h:i:s'),
                ],[
                'action_id' => '1',
                'type'=>'1',
                'tags'=>'#user_name#',
                'message'=>"Dear #user_name# ,<br /><br />
                            Your property '#property_name#' has been booked by #buyer_name# from #from_date# to #end_date#.
                            <br /><br />
                            Regards,<br />
                            ShareAir Team" ,
                'created_at' => date('Y-m-d h:i:s'),
            ],[
                'action_id' => '1',
                'type'=>'1',
                'tags'=>'#user_name#',
                'message'=>"Dear #user_name# ,<br /><br />
                           Your request for the property '#property_name#' has been confirmed/booked from #from_date# to #end_date#.
                            <br /><br />
                            Regards,<br />
                            ShareAir Team",
                'created_at' => date('Y-m-d h:i:s'),
            ],[
                'action_id' => '1',
                'type'=>'1',
                'tags'=>'#user_name#',
                'message'=>"Dear #user_name# ,<br /><br />
                           You have a pending request for property '#property_name#'. Please #click_here# to approve the booking.
                            <br /><br />
                            Regards,<br />
                            ShareAir Team",
                'created_at' => date('Y-m-d h:i:s'),
            ],[
                'action_id' => '1',
                'type'=>'1',
                'tags'=>'#user_name#',
                'message'=>"Dear #user_name# ,<br /><br />
                          It's been 48 hr, but still #buyer_name# has not booked the property '#property_name#'.<br />
                           If you want to cancel the booking. Please #click_here#.<br /><br />
                            Regards,<br />
                            ShareAir Team",
                'created_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MessageToBeSend extends Model
{
    protected $table = 'message_to_be_send';

    protected $fillable = ['approved_token','type','subject','body','email','url','mobile_no','is_send'];

}

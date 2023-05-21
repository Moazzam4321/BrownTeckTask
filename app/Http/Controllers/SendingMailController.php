<?php

namespace App\Http\Controllers;

use App\Jobs\SendingMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SendingMailController extends Controller
{
    public static function send_mail($user_email)
    {
        try{
            
            SendingMail::dispatchAfterResponse($user_email);
        } catch(Exception $e){
            Log::error('Some issue while sending mail',['user_email',$user_email]);
            return   $e->getMessage();
        }
    }
}

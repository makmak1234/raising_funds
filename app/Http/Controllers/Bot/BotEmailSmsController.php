<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;
use App\Investors;
// use App\Invest;
use Carbon\Carbon;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MyFunction\Transport;

class BotEmailSmsController extends Controller
{
	/**
     * The user repository instance.
     */
    // protected $botEmailSms;

    // public function __construct(BotEmailSmsController $botEmailSms){
    //     $this->botEmailSms = $botEmailSms;
    // }

    // public function BotEmailSmsAction(){

    // 	$this->EmailSendAction($investors);
    //     $this->SmsSendAction($investors);
    // 	return;
    // }

    public function EmailSendAction($investors, $text_email){
    	// send_email($qiwi_wallet["email"],  mb_substr($email_send, 0, 40), $email_send, 'money@bazabd.xyz', 'Милитарихолдинг');
    	$name = 'name';
        // $order = '$order';
        // $title = '$title';
        // $tel = '$tel';
        // $email = '$email';
        // $city = '$city';
        // $pricegoods = '$pricegoods';
        // $priceall = '$priceall';
        // $comment = '$comment';
        // $sizeTitle = '$sizeTitle';
        // $colorTitle = '$colorTitle';
        // $nid = '$nid';
        // $priceone = '$priceone';  
        foreach ($investors as $investor) {
            $text_send = $text_email;
            $name = $investor->name;
            $email = $investor->email;
            eval("\$text_send = \"$text_send\";");
            Mail::to($email)->send(new OrderShipped($text_send));
            sleep(5);
        } 	
    	
    	return;
    }
    
    public function SmsSendAction($investors, $text_sms){
        $sms = new Transport();
        foreach ($investors as $investor) {
            $text_send = $text_email;
            $name = $investor->name;
            $phone = $investor->phone;
            eval("\$text_send = \"$text_send\";");
            $ok = $sms->send(array("text" => $text_send), array(substr($phone, 1)));
            sleep(5);

$myecho = json_encode($ok);
`echo " ok: $myecho    " >>/tmp/qaz`;

        }   
    	
        return;
    }

}
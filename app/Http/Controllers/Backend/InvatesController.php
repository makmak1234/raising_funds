<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Investors;
use App\Invest;
use App\Text;
use App\Http\Controllers\Bot\BotEmailSmsController;
use Carbon\Carbon;
use App\Jobs\BotEmailSms;
use App\Jobs\BotEmailSms_test;

class InvatesController extends Controller
{
    /**
     * The user repository instance.
     */
    protected $botEmailSms;

    public function __construct(BotEmailSmsController $botEmailSms){
        $this->botEmailSms = $botEmailSms;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function invatesInvestors($message = null)
    {
        $text_email = Text::where('type', 'text_email')->get();
        $text_sms = Text::where('type', 'text_sms')->get();
// $myecho = json_encode($text_email);
// `echo " text_email:    " $myecho  >>/tmp/qaz`;
        return view('backend.invates', ["text_email" => $text_email[0]->order_text, "text_sms" => $text_sms[0]->order_text, "message" => $message, ]);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function invatesErrorInvestors($send_email = null, $send_sms = null)
    {

        return view('backend.invates',  ["send_email" => $send_email, "send_sms" => $send_sms]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function invatesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text_email' => 'required_with:send_email',
            'text_sms' => 'required_with:send_sms',
        ]);

        // $this->validate($request, [
        //     'text_email' => 'required_with:send_email',
        //     'text_sms' => 'required_with:send_sms',
        // ]);

        // $myecho = $request->send_email;
        // $myecho2 = $request->send_sms;
        // `echo " request_send_email_sms:    " $myecho  "  " $myecho2 >>/tmp/qaz`;
        // $myecho = json_encode($request->text_email);
        // `echo " request_send_text_email:    " $myecho  >>/tmp/qaz`;

        // exit;

        // $old = array('text_email'=>$request->text_email, 'text_sms'=>$request->text_sms, 'send_email'=>$request->send_email, 'send_sms'=>$request->send_sms);
        if ($validator->fails()) {
            return redirect()->route('dash_invates_error', ["send_email" => $request->send_email, "send_sms" => $request->send_sms,])//redirect('dash_invates')
                        ->withErrors($validator)
                        ->withInput();
        }

        $message = "";
// $myecho = json_encode($request->only('text_email', 'text_sms', 'send_email', 'send_sms'));
// `echo " request_invates: $myecho    " >>/tmp/qaz`;

        dispatch(new BotEmailSms($request->only('text_email', 'text_sms', 'send_email', 'send_sms')));
        $investors = Investors::select('name', 'email', 'phone')->get();
        if($request->send_email){
            Text::updateOrCreate(
                ['type' => 'text_email'],
                ['order_text' => $request->text_email]
            );
            // $this->botEmailSms->EmailSendAction($investors, $request->text_email);
            $message .= "email "; 
        }
        if($request->send_sms){
            Text::updateOrCreate(
                ['type' => 'text_sms'],
                ['order_text' => $request->text_sms]
            );
            // $this->botEmailSms->SmsSendAction($investors, $request->text_sms);
            $message .= "sms ";  
        }

        // $request = $request->only('text_email', 'text_sms', 'send_email', 'send_sms');
        // `php5 BotEmailSms.php $request > /dev/null &`;

        return redirect()->route('dash_invates', ["message" => $message]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailView($text_email)
    {
        $investors = Investors::select('name', 'email', 'phone', 'hash')->first();
        // $text_email = Text::where('type', 'text_email')->get();
        $text_send = $text_email;//$text_email[0]->order_text;
        $name = $investors->name;
        $email = $investors->email;
        $hash = $investors->hash;
        eval("\$text_send = \"$text_send\";");

        return view('mail.emailAdmin',  ["name" => $text_send, "hash" => $hash]);
    }
    

}
<?php

namespace App\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
// use App\Text;
// use App\Investors;
use App\Mail\OrderShipped;
// use Illuminate\Support\Facades\Mail;
// use App\Http\Controllers\MyFunction\Transport;

class BotEmailSms_test implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     protected $request;
     // protected $investors;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        // $this->investors = $investors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = $this->request;
        // $investors = $this->investors;
$myecho = json_encode($request);
`echo " request_bot: $myecho    " >>/tmp/qaz`;
sleep(10);
// exit;
        // $sms = new Transport();
        // $investors = $investors->select('name', 'email', 'phone')->get();//Investors::select('name', 'email', 'phone')->get();
        // if(isset($request['send_email']) && $request['send_email']){
        //     Text::updateOrCreate(
        //         ['type' => 'text_email'],
        //         ['order_text' => $request['text_email']]
        //     );
        //     $this->EmailSendAction($investors, $request['text_email']); 
        // }
        // if(isset($request['send_sms']) && $request['send_sms']){
        //     Text::updateOrCreate(
        //         ['type' => 'text_sms'],
        //         ['order_text' => $request['text_sms']]
        //     );
        //     $this->SmsSendAction($investors, $request->text_sms, $sms);  
        // }
        return;
    }

//     public function EmailSendAction($investors, $text_email){
//         $name = 'name'; 
//         foreach ($investors as $investor) {
//             $text_send = $text_email;
//             $name = $investor->name;
//             $email = $investor->email;
//             eval("\$text_send = \"$text_send\";");
//             // $ok = Mail::to($email)->send(new OrderShipped($text_send));
//             sleep(5);

// // $myecho = json_encode($ok);
// // `echo " ok_email: $myecho    " >>/tmp/qaz`;
//         }   
        
//         return;
//     }
    
//     public function SmsSendAction($investors, $text_sms, $sms){
//         foreach ($investors as $investor) {
//             $text_send = $text_email;
//             $name = $investor->name;
//             $phone = $investor->phone;
//             eval("\$text_send = \"$text_send\";");
//             $ok = $sms->send(array("text" => $text_send), array(substr($phone, 1)));
//             sleep(5);

// $myecho = json_encode($ok);
// `echo " ok_sms: $myecho    " >>/tmp/qaz`;

        // }   
        
        // return;
    // }
}

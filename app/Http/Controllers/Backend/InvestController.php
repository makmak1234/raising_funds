<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Investors;
use App\Invest;
use App\Parameters;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvestController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function investors()
    {
    	$investors = Investors::get();

        foreach ($investors as $investor) {
            // $tmp = $investor->invests->select('amount')->get();

            $amounts = DB::table('invests')
                ->where('invests.investors_id', '=', $investor['id'])
                ->select('invests.amount')
                ->get();
            $i = 0;
            $all = 0;
            foreach ($amounts as $amount) {
                $all += $amount->amount;
                $i++;
            }
            $amount_all[] = $all;
            $amount_count[] = $i;
            $amount = array_sum($amount_all);
        }

        // $myecho = json_encode($amounts);
        // `echo " myamount:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`; 

        return view('backend.investors', ["investors" => $investors, "amount_all" => $amount_all, "amount_count" => $amount_count, "amount" => $amount,]);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeInvestor(Request $request)
    {   
        if (isset($request->id)) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'yan_money' => 'required|string|max:20',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255',
            ]);
            $phone = $this->clear_fone($request['phone']);

            DB::table('investors')
                ->where('id', $request->id)
                ->update(['name' => $request['name'],
                    'yan_money' => $request['yan_money'],
                    'phone' => $phone,
                    'email' => $request['email'],
                ]);
            if ($request['password'] != "false1") {
                $this->validate($request, [
                'password' => 'required|string|min:3|confirmed',
            ]);
                DB::table('investors')
                ->where('id', $request->id)
                ->update([
                    'password' => bcrypt($request['password']),
                ]);
            }
        }else{
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'yan_money' => 'required|string|max:20',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:investors',
                'password' => 'required|string|min:3|confirmed',
            ]);
            $phone = $this->clear_fone($request['phone']);
            $hash = md5(env('SALT1') . time() . env('SALT2'));

            //  $myecho = env('SALT1');
            // `echo " SALT1:  $myecho  " >>/tmp/qaz`;
            // $myecho = time();
            // `echo " time:  $myecho  " >>/tmp/qaz`;
            // exit();

            $investor = Investors::create([
                'name' => $request['name'],
                'yan_money' => $request['yan_money'],
                'phone' => $phone,
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'hash' => $hash,
            ]);

            // $investor = new Investors;
            // $investor->name = $request['name'];
            // $investor->yan_money = $request['yan_money'];
            // $investor->phone = $request['phone'];
            // $investor->email = $request['email'];
            // $investor->password = bcrypt($request['password']);
            // $investor->save();
        }

        //  $myecho = $request['front'];
        // `echo " front:  $myecho  " >>/tmp/qaz`;

        if ($request['front'] == 'true') {
            Auth::guard('investors')->login($investor);
            return redirect()->route('front_show_investor', ['id' => $investor->id]);           
        }else{
            return redirect()->route('dash_investors');
        }
    }

    //очистка телефона
    private function clear_fone($person_phone){
        $phone = str_replace(array("+", " ", "(", ")", "-"), "", $person_phone);

        return $phone;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInvestor($id)
    {
        $investor = Investors::find($id);
        return view('backend.update_investor', ["investor" => $investor]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteInvestor($id)
    {
        $investor = Investors::find($id);
        $investor->delete();
        // $investor = Investors::get();
        return redirect()->route('dash_investors');
        // return view('backend.users', ["investors" => $investors]);
    }

    public function showInvest($id)
    {
        $investor = Investors::find($id);

        $invests = $investor->invests;
        $end_amount = count($invests)>0 ? $invests[count($invests)-1]->amount : '';
        $end_label = count($invests)>0 ? $invests[count($invests)-1]->label : '';

        $amount = 0;
        foreach ($invests as $invest) {
            $amount += $invest->amount;
        }

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        return view('backend.show_invests', ["investor" => $investor, "invests" => $invests, "accept" => $accept, "amount" => $amount, 'end_amount' => $end_amount, 'end_label' => $end_label]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSolve($id, $accept)
    {
        DB::table('invests')
            ->where('id', $id)
            ->update([
                'accept' => $accept,
            ]);

        $id_investor = Invest::find($id)->investors->id;

        return redirect()->route('dash_show_invests', [$id_investor]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeInvest(Request $request)
    {   
        if (isset($request->id)) {
            $this->validate($request, [
                'amount' => 'required|numeric|max:1000000000|min:2',
                'term' => 'required|date|after:tomorrow',
            ]);

            DB::table('invests')
                ->where('id', $request->id)
                ->update(['amount' => $request['amount'],
                    'term' => $request['term'],
                    'accept' => $request['accept'],
                ]);
        }else{
            $this->validate($request, [
                'amount' => 'required|numeric|max:1000000000|min:1',
                'term' => 'required|date|after:tomorrow',
            ]);

            Invest::create([
                'amount' => $request['amount'],
                'label' => env('ID_SHOP') . intval($request->amount) . random_int(10000, 99999),
                'term' => $request['term'],
                'investors_id' => $request['id_investor'],
                'accept' => $request['accept'],
            ]);
        }

        // $id_investor = Invest::find($request->id)->investors->id;

        if ($request['front'] == 'true') {
            return redirect()->route('front_show_investor', ['id' => $request->id_investor, 'id_form' => 'true']);           
        }else{
            return redirect()->route('dash_show_invests', ['id' => $request->id_investor]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInvest($id)
    {
        $investor = Invest::find($id)->investors;
        $invest = Invest::find($id);
        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];
        $date_now = Carbon::tomorrow()->toDateString();
        return view('backend.update_invest', ["invest" => $invest, "investor" => $investor, "accept" => $accept, "date_now" => $date_now]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSentInvest(Request $request)
    {
        DB::table('invests')
            ->where('label', $request->label)
            ->update(['amount_type' => '2',
                'time_got' => Carbon::now(),
            ]);

        return redirect()->route('dash_show_invests', [$request->id_investor]);
        // $investor = Invest::find($id)->investors;
        // $invest = Invest::find($id);
        // $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];
        // $date_now = Carbon::tomorrow()->toDateString();
        // return view('backend.update_invest', ["invest" => $invest, "investor" => $investor, "accept" => $accept, "date_now" => $date_now]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteInvest($id)
    {
        $id_investor = Invest::find($id)->investors->id;
        $invest = Invest::find($id);
        $invest->delete();

        return redirect()->route('dash_show_invests', [$id_investor]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addInvest($id)
    {
        $investor = Investors::find($id);
        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];
        $date_now = Carbon::tomorrow()->toDateString();
//  $myecho = $date_now;
// `echo "date_now: " . $myecho >>/tmp/qaz`; 

        return view('backend.add_invest', ["investor" => $investor, "accept" => $accept, "date_now" => $date_now]);
    }

    public function confirmTransfer(Request $request)
    {

        $yan_secret = DB::table('parameters')->where('title', 'yan_secret')->get();

        $secret_str = $request['notification_type'] . '&' . $request['operation_id'] . '&' . $request['amount'] . '&'. $request['currency']. '&'. $request['datetime']. '&' .$request['sender']. '&'. $request['codepro'] .'&'. $yan_secret[0]->parameter . '&'. $request['label'];

        $secret = sha1($secret_str);
        
//  $myecho = json_encode($secret);
// `echo "secret: "  $myecho >> /tmp/qaz`;

        $datetime = $request['datetime'];
        $datetime = str_replace("T", " ", $datetime);
        $datetime = str_replace("Z", " ", $datetime);

        if ($secret == $request['sha1_hash']) {
            DB::table('invests')
            ->where('label', $request['label'])
            ->update([
                'amount_got' => $request['amount'],
                'amount_type' => '1',
                'time_got' => $datetime,
                'label' => $request['label'],
                'operation_id' => $request['operation_id'],
                'full_answer' => json_encode($_POST),
            ]);
        }

        DB::table('admins')
            ->where('id', 1)
            ->update([
                'name' => $secret,
            ]); 

        DB::table('admins')
            ->where('id', 2)
            ->update([
                'name' => json_encode($_POST),
            ]); 

        DB::table('admins')
            ->where('id', 3)
            ->update([
                'name' => $secret_str,
            ]); 

        DB::table('admins')
            ->where('id', 4)
            ->update([
                'name' => $request['sha1_hash'],
            ]);

        return response('HTTP 200 OK')
                  ->header('Content-Type', 'text/plain');
    }

    public function redirectYandex(){
        $xml_data = array ("receiver" => "410013775631887",
            "formcomment" => "Инвестиции для Миллитарихолдинг",
            "short-dest" => "Инвестиции для Миллитарихолдинг",
            "label" => "order_id",
            "quickpay-form" => "donate",
            "targets" => "транзакция {order_id}",
            "sum" => "48.25",
            "comment" => "Инвестиции для Миллитарихолдинг",
            "need-fio" => "410013775631887",
            "need-email" => "410013775631887",
            "need-phone" => "410013775631887",
            "need-address" => "410013775631887"
            );
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'https://money.yandex.ru/quickpay/confirm.xml');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_data);                                                                                                                                      
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: text/xml',
                'Content-Length: ' . strlen(implode($xml_data)))
            ); 
            
            $out = curl_exec($curl);
            curl_close($curl);

            // header ("Location: $dirbasbi1");

             $myecho = json_encode($out);
            `echo "out: " . $myecho >>/tmp/qaz`; 
            // exit;
            return;
        }
    }

    public function addLabel(Request $request)
    {
       $count_invst = Invest::count(); 

$str = '{"amount":"150.00","datetime":"2017-11-28 12:05:30","label":"label","full_answer":"{\"notification_type\":\"p2p-incoming\",                            \"amount\":\"306.83\",                            \"datetime\":\"2017-12-29T15:01:30Z\",                            \"codepro\":\"false\",                            \"sender\":\"41001000040\",                            \"sha1_hash\":\"0a012ef5ebd0b0cbff1ddb212a5440ac21e71597\",                            \"test_notification\":\"true\",                            \"operation_label\":\"\",                            \"operation_id\":\"test-notification\",                            \"currency\":\"643\",                            \"label\":\"\"}"}';
 $myecho = strlen($str);
`echo "strlen: "  $myecho >> /tmp/qaz`; 

$invest = Invest::find(8);
$myecho = ($invest->created_at);
`echo "created_at: "  $myecho >> /tmp/qaz`; 
        
        // $invests = Invest::all();
        // foreach ($invests as $invest) {
        //     $label = env('ID_SHOP') . intval($invest->amount) . random_int(10000, 99999);
        //     $invest->update([
        //         'label' => $label,
        //     ]);
        // }

               
        // return response()
        //     ->header('HTTP 200 OK');
    }
}

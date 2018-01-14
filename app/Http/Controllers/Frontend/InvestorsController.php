<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Investors;
use App\Parameters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;


class InvestorsController extends Controller
{
    /**
     * Вывод формы авторизации
     *
     * @return Response
     */
    public function authForm()
    {
        Auth::guard('investors')->logout();
        if (Auth::guard('investors')->check())
            return redirect("/private");

        return View($this->frontendtemplate.'.frontend.auth.login');
    }

    /**
     * Авторизация пользователя
     *
     * @return Response
     */
    public function checkInvestor(Request $request)
    {
        // $myecho = json_encode($request);
        // `echo " request: $myecho    " >>/tmp/qaz`;
        // if (Auth::guard('investors')->check() || Auth::guard('investors')->attempt(["phone" => $request->phone, "password" => $request->password])){
        //     $investor = Auth::guard('investors')->user();
        //     $invests = $investor->invests;
        //     $yan_money = Parameters::where('title', 'yan_money')->get();

        //     $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        //     return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept, 'id_form' => 'false', 'yan_money' => $yan_money]);
        // }

        if (Auth::guard('investors')->check() || Auth::guard('investors')->attempt(["phone" => $request->phone, "password" => $request->password])) {
            $investor = Auth::guard('investors')->user();

            $yan_money = Parameters::where('title', 'yan_money')->get();
            $qiwi_wallet = Parameters::where('title', 'qiwi_wallet')->get();
            $qiwi_wallet = $qiwi_wallet[0]->parameter;

            $invests = $investor->invests;

            $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

            return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept, 'id_form' => 'false', 'yan_money' => $yan_money, 'qiwi_wallet' => $qiwi_wallet]);
            // return redirect()->route('front_show_investor', ["id" => $investor->id]);
        }
        else{
            $message = "Телефон или пароль неверен";
            return view("frontend.auth_investor", ["message" => $message]);
        }
    }

    /**
     * Авторизация пользователя
     *
     * @return Response
     */
    public function hashInvestor($hash = null)
    {
        if (Investors::where('hash', $hash)->get()){
            $investor = Investors::where('hash', $hash)->get();
            $investor = $investor[0];
            Auth::guard('investors')->login($investor);
            $invests = $investor->invests;
            $yan_money = Parameters::where('title', 'yan_money')->get();
            $qiwi_wallet = Parameters::where('title', 'qiwi_wallet')->get();
            $qiwi_wallet = $qiwi_wallet[0]->parameter;

            $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

            return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept, 'id_form' => 'false', 'yan_money' => $yan_money, 'qiwi_wallet' => $qiwi_wallet]);
        }
        else{
            // $message = "Телефон или пароль неверен";
            return view("frontend.auth_investor");//, ["message" => $message]
        }
    }

    public function privateLogout(){
        Auth::guard('investors')->logout();
        return redirect()->route("priv_auth_investor");
    }

    public function showInvest($id, $id_form = 'false')
    {
        $investor = Investors::find($id);

        $investor_check = Auth::guard('investors')->user();

        if ($id != $investor_check->id) {
            return redirect()->route("priv_auth_investor");
        }

        // Auth::guard('investors')->login($investor);

        $invests = $investor->invests;

        $yan_money = Parameters::where('title', 'yan_money')->get();
        $qiwi_wallet = Parameters::where('title', 'qiwi_wallet')->get();
        $qiwi_wallet = $qiwi_wallet[0]->parameter;

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept, 'id_form' => $id_form, 'yan_money' => $yan_money, 'qiwi_wallet' => $qiwi_wallet]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addInvest($id)
    {
        $investor = Investors::find($id);
        $investor_check = Auth::guard('investors')->user();

        if ($id != $investor_check->id) {
            return redirect()->route("priv_auth_investor");
        }

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];
        $date_now = Carbon::tomorrow()->toDateString();

        return view('frontend.add_invest', ["investor" => $investor, "accept" => $accept, "date_now" => $date_now]);
    }

    // public function showSentInvest($id, $id_invest, $id_form = 'false')
    // {
    //     $investor = Investors::find($id);

    //     $investor_check = Auth::guard('investors')->user();

    //     if ($id != $investor_check->id) {
    //         return redirect()->route("priv_auth_investor");
    //     }

    //     $invests = $investor->invests;

    //     DB::table('invests')
    //         ->where('id', $id_invest)
    //         ->update([
    //             'amount_type' => '3',
    //         ]);

    //     $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

    //     return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept, 'id_form' => $id_form]);
    // }


}

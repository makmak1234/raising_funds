<?php namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Investors;
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
 
        if (Auth::guard('investors')->attempt(["phone" => $request->phone, "password" => $request->password])) {
            $investor = Auth::guard('investors')->user();
            // $client = $user->client()->first();

            // if ($client->trashed())
            //     return response()->json(["success" => false, "message" => trans("auth.auth-client-disabled")]);

            // $token = str_random(100);
            // $user->update([
            //     "token"         => $token,
            //     "token_expired" => Carbon::now()->addMinutes(config("app.token_expired"))
            // ]);

            $invests = $investor->invests;

            $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

            return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept]);
            // return redirect()->route('front_show_investor', ["id" => $investor->id]);
        }
        else{
            $message = "Телефон или пароль неверен";
            return view("frontend.auth_investor", ["message" => $message]);
        }
    }

    public function privateLogout(){
        Auth::guard('investors')->logout();
        return redirect()->route("priv_auth_investor");
    }

    public function showInvest($id)
    {
        $investor = Investors::find($id);

        $investor_check = Auth::guard('investors')->user();

        if ($id != $investor_check->id) {
            return redirect()->route("priv_auth_investor");
        }        

        // Auth::guard('investors')->login($investor);

        $invests = $investor->invests;

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        return view('frontend.investor', ["investor" => $investor, "invests" => $invests, "accept" => $accept]);
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

}

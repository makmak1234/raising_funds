<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Parameters;

class AdminController extends Controller
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
    public function users()
    {
    	$users = User::get();
        return view('backend.users', ["users" => $users]);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        // if ($error->fails()) {
        //     return redirect('bag_register_secure')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        if (isset($request->id)) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:20',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255',
            ]);
            $phone = $this->clear_fone($request['phone']);

            DB::table('users')
                ->where('id', $request->id)
                ->update(['name' => $request['name'],
                    'login' => $request['login'],
                    'phone' => $phone,
                    'email' => $request['email'],
                ]);
            if ($request['password'] != "false1") {
                $this->validate($request, [
                'password' => 'required|string|min:3|confirmed',
            ]);
                DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'password' => bcrypt($request['password']),
                ]);
            }
        }else{
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'login' => 'required|string|max:20',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3|confirmed',
            ]);
            $phone = $this->clear_fone($request['phone']);

            User::create([
            'name' => $request['name'],
            'login' => $request['login'],
            'phone' => $phone,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        }

        return redirect()->route('dash_users');
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
    public function updateUser($id)
    {
        $user = User::find($id);
        return view('backend.update_user', ["user" => $user]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        $users = User::get();
        return view('backend.users', ["users" => $users]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewParamYandex($yan_money = "", $yan_secret = "")
    {
        $parameters = Parameters::all();
// $myecho = json_encode($parameters[0]);
// `echo "parameters: "  $myecho >> /tmp/qaz`;
        if (isset($parameters[0])) {
            $yan_money = $parameters[0]->parameter;
            $yan_secret = $parameters[1]->parameter;
        }


        return view('backend.parameters_yandex', ["yan_money" => $yan_money, "yan_secret" => $yan_secret]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewParamQiwi($qiwi_wallet = "", $qiwi_token = "")
    {
        $parameters = Parameters::all();
// $myecho = json_encode($parameters[0]);
// `echo "parameters: "  $myecho >> /tmp/qaz`;
        $qiwi_token_exp = Carbon::tomorrow()->toDateString();
        if (isset($parameters[2])) {
            $qiwi_wallet = $parameters[2]->parameter;
            $qiwi_token = $parameters[3]->parameter;
            $qiwi_token_exp = $parameters[4]->parameter;
        }
        $date_now = Carbon::tomorrow()->toDateString();

        return view('backend.parameters_qiwi', ["qiwi_wallet" => $qiwi_wallet, "qiwi_token" => $qiwi_token, "qiwi_token_exp" => $qiwi_token_exp, "date_now" => $date_now]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeParameters(Request $request)
    {
        // if ($error->fails()) {
        //     return redirect('bag_register_secure')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        $route_redir = "dash_parametrs";
        if ($request->yan_money) {
          $this->validate($request, [
              'yan_money' => 'required|numeric|max:999999999999999',
              'yan_secret' => 'required|string|max:30',
          ]);
          Parameters::updateOrCreate(
              ['title' => 'yan_money'],
              ['parameter' => $request->yan_money]
          );
          Parameters::updateOrCreate(
              ['title' => 'yan_secret'],
              ['parameter' => $request->yan_secret]
          );
          $route_redir = "dash_param_yan";
        }elseif ($request->qiwi_wallet) {
          $this->validate($request, [
              'qiwi_wallet' => 'required|string|max:14',
              'qiwi_token' => 'required|string|max:40|min:20',
              'qiwi_token_exp' => 'required|date|after:tomorrow',
          ]);
          Parameters::updateOrCreate(
              ['title' => 'qiwi_wallet'],
              ['parameter' => $request->qiwi_wallet]
          );
          Parameters::updateOrCreate(
              ['title' => 'qiwi_token'],
              ['parameter' => $request->qiwi_token]
          );
          Parameters::updateOrCreate(
              ['title' => 'qiwi_token_exp'],
              ['parameter' => $request->qiwi_token_exp]
          );
          $route_redir = "dash_param_qiwi";
        }


        return redirect()->route($route_redir);
    }
}

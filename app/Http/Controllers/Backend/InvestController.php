<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Investors;

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
        }

        // $myecho = json_encode($amounts);
        // `echo " myamount:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`; 

        return view('backend.investors', ["investors" => $investors, "amount_all" => $amount_all, "amount_count" => $amount_count]);
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
                'phone' => 'required|string|max:13',
                'email' => 'required|string|email|max:255',
            ]);

            DB::table('investors')
                ->where('id', $request->id)
                ->update(['name' => $request['name'],
                    'yan_money' => $request['yan_money'],
                    'phone' => $request['phone'],
                    'email' => $request['email'],
                ]);
            if ($request['password'] != "false1") {
                $this->validate($request, [
                'password' => 'required|string|min:6|confirmed',
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
                'phone' => 'required|string|max:13',
                'email' => 'required|string|email|max:255|unique:investors',
                'password' => 'required|string|min:6|confirmed',
            ]);

            Investors::create([
            'name' => $request['name'],
            'yan_money' => $request['yan_money'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        }

        return redirect()->route('dash_investors');
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
        $investor = Investors::get();
        return view('backend.users', ["investors" => $investors]);
    }

    public function showInvest($id)
    {
        $investor = Investors::find($id);

        $invests = $investor->invests;

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        return view('backend.show_invests', ["investor" => $investor, "invests" => $invests, "accept" => $accept]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInvest($id, $accept)
    {
        DB::table('invests')
            ->where('id', $id)
            ->update([
                'accept' => $accept,
            ]);

        $id_investor = Invests::find($id)->investors->id;

        return redirect()->route('dash_show_invests', [$id_investor]);
    }
}

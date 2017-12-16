<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Investors;
use App\Invest;
use Carbon\Carbon;

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

            $investor = Investors::create([
                'name' => $request['name'],
                'yan_money' => $request['yan_money'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
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
            return redirect()->route('front_show_investor', ['id' => $investor->id]);           
        }else{
            return redirect()->route('dash_investors');
        }
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

        $accept=['0' => 'Отказано', '1' => 'Принято', '2' => 'Решается'];

        return view('backend.show_invests', ["investor" => $investor, "invests" => $invests, "accept" => $accept]);
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
                'amount' => 'required|numeric|max:1000000000|min:1',
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
                'term' => $request['term'],
                'investors_id' => $request['id_investor'],
                'accept' => $request['accept'],
            ]);
        }

        // $id_investor = Invest::find($request->id)->investors->id;

        if ($request['front'] == 'true') {
            return redirect()->route('front_show_investor', ['id' => $request->id_investor]);           
        }else{
            return redirect()->route('dash_show_invests', [$request->id_investor]);
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
}

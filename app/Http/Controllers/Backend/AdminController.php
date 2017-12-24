<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

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
}

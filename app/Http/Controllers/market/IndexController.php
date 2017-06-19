<?php

namespace App\Http\Controllers\market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests;

use Session;
use App\Admins;
use App\Market;

class IndexController extends Controller
{
    public function index()
    {
      if(Session::get('m_status')==TRUE)
        return view('market.home');
      else
        return view("market.login");
    }
    public function postLogin(Request $request)
    {
      if(Session::get('market_status')==TRUE)
            return redirect('market/home');
        else
        {
              $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
                 ]);
            $email = $request->email;
            $password = $request->password;
            $password = md5($password);
            //dd($password);
            //dd($password);
            $query = Market::where('email',$email)->where('password',$password)->where('active','1')->first();
            //dd($query);
            if($query!=null){
                //var_dump("asdasda");
                Session::set('m_status',TRUE);
                Session::set('memail',$query->email);
                return redirect('marketing/home');
            }
            else
            {
                Session::flash('flash_message', 'Your Email or password is incorrect');
                return view('market.login');
            }
        }
    }
    public function logout()
    {
        Session::flush();
        Session::flash('flash_message', 'You have been successfully Logout');
        return redirect('marketing');
    }

}

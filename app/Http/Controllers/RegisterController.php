<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Handlers\Client;
use App\Handlers\jsonRPCClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    public function test()
    {
          $client = new Client(getenv('FAL_HOST'),getenv('FAL_PORT'),getenv('FAL_USER'),getenv('FAL_PASS'));
        dd($client);
    }

    public function register()
    {
        return view('front.signup');
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'name'          => 'required|string|min:6|max:20|unique:users,name',
            'email'         => 'required|email|unique:users,email|confirmed',
            'password'      => 'required|min:6|confirmed',
            'captcha'       => 'required|captcha',
        ]);

        $data = array_merge($request->all(),['confrimed_code'=>str_random(60)]);
        $user  = User::create($data);

        /*$fal_client = new Client(getenv('FAL_HOST'),getenv('FAL_PORT'),getenv('FAL_USER'),getenv('FAL_PASS'));
        $btc_client = new Client(getenv('BTC_HOST'),getenv('BTC_PORT'),getenv('BTC_USER'),getenv('BTC_PASS'));

        $fal_client->getAddress();
        $btc_client->getAddress();*/

        $name  = $user->name;
        $token = $user->confrimed_code;
        /*Mail::send('email.welcome',['name'=>$name,'token'=>$token],function($message) use ($user){
            $message ->to($user->email)->subject('Confirmed Register Email');
        });*/
        // 判断是否发送成功
        //dd(Mail::failures());
        return redirect('/signin');
    }

    public function confrimedEmail($confrimed_code,Request $request)
    {
        $user = User::where('confrimed_code',$confrimed_code)->where('is_confrimed','0')->first();
        if(is_null($user)) {
            return redirect('/signup');
        }
        $user->is_confrimed     = 1;
        $user->confrimed_code   = str_random(60);
        $user->save();
        $request->session()->flash('login_error_info', '您已经成功验证邮箱可以登陆');
        return redirect('/signin');
    }



}

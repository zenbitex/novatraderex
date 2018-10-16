<?php

namespace App\Http\Controllers;

use App\ForgetPassword;
use App\Models\User;
use App\Models\UserLoginInfo;
use Carbon\Carbon;
use Mail;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        \Auth::logout();
        return view('front.signin');
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email'      => 'required',
            'pwd'        => 'required',
        ]);

        $email_is_verified = User::where('email',$request->email)->value('is_confrimed');
        if($email_is_verified == 3) {
            $request->session()->flash('login_error_info', trans('login.email_no_verify'));
        }else{
            if ((\Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('pwd')])) ) {
                $logininfo = UserLoginInfo::where('user_id',\Auth::id())->select('login_time','login_ip')->first();
                UserLoginInfo::updateOrCreate([
                    'user_id'        => \Auth::id()],
                    [
                        'login_time'     => Carbon::now(),
                        'login_ip'       => $request->getClientIp(),
                        'last_login_time'=> $logininfo['login_time'] ? $logininfo['login_time'] : Carbon::now(),
                        'last_login_ip'  => $logininfo['login_ip'] ? $logininfo['login_ip'] : '::1',
                    ]);
                return redirect("/wallets/balances");
            }
            $request->session()->flash('login_error_info', trans('login.password_error'));
        }

        return redirect('signin')->withInput($request->all());
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('signin');
    }

    public function sendForgetEmail(Request $request)
    {
        $this->validate($request,[
            'forget_email' => 'email',
        ]);
        $user = User::where('email',$request->forget_email)->first();
        if(is_null($user)){
            return ['code'=>404,'message'=>'邮箱未注册'];
        }
        $name = $user->name;
        $user_id = $user->id;
        $time = time();
        $forget_token = str_random(185);
        ForgetPassword::create(['user_id'=>$user_id,'forget_token'=>$forget_token]);
        $str = md5('forgetPass'.$time.'wrod');
        Mail::send('email.forgetpassword',['name'=>$name,'token'=>encrypt($forget_token),'time'=>$time,'sign'=>$str],function($message) use ($user){
            $message ->to($user->email)->subject('Reset Password Email');
        });
        if(empty(Mail::failures())) {
            return ['code'=>200];
        }else{
            return ['code'=>400];
        }
    }

    public function showResetPassword($token,$time,$sign,Request $request)
    {
        $diff = time()-$time;
        if($diff > 1800){
            $request->session()->flash('login_error_info', '邮箱找回密码验证过期，请重试');
            return redirect('/signin');
        }
        return view('front.forgetpassword',compact('token','time','sign'));
    }

    public function resetPassword(Request $request,$token,$time,$sign)
    {
        $this->validate($request,[
            'email'     => 'required|email',
            'password'  => 'required|min:6|string|confirmed',
        ]);
        $forget_token = decrypt($token);
        $forget_model  = ForgetPassword::where('forget_token',$forget_token)->first();
        if(is_null($forget_model)){
            $request->session()->flash('login_error_info', '找回密码失败，请重试');
            return redirect('/signin');
        }
        $user = User::where('id',$forget_model->user_id)->first();
        if(($user->email != $request->get('email') ) ) {
            $request->session()->flash('login_error_info', '找回密码失败，请重试');
            return redirect('/signin');
        }
        User::where('id',$user->id)->update(['password'=>bcrypt($request->get('password'))]);
        ForgetPassword::where('user_id',$forget_model->user_id)->update(['forget_token'=>str_random(185)]);
        $request->session()->flash('login_error_info', '密码修改成功');
        return redirect('/signin');
    }
}

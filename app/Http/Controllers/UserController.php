<?php

namespace App\Http\Controllers;

use App\Models\UserLoginInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apikey;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth',['except'=>'test']);
    }

	public function test()
	{
		$cli = $this->getBTCClient();
		$balance = $cli->getBalance(1);
		$res = $cli->getTransactionList(1);
dd($res);	
	}

    public function bind()
    {
        return view('front.bind');
    }

    public function dobind(Request $request)
    {
        if(Auth::check()){
            $this->validate($request,[
                'key'   => 'required',
                'secret'=> 'required',
            ]);
            $user_id = Auth::id();
            Apikey::firstOrCreate([
                'user_id'=>$user_id,
                'key'=>encrypt($request->get('key')),
                'secret'=>encrypt($request->get('secret'))
            ]);
            //todo 返回成功
        }
        return redirect('signin');
    }

    public function profile()
    {
        $user_id = Auth::id();
        $info = User::where('id',$user_id)->with('loginInfo')
                ->select('id','name','email','created_at','secpass','is_certification')
                ->first();
        $apikey = Apikey::where('user_id',$user_id)->select('key','secret')->first();
        $have_pass = (bool)($info['secpass']);
        $logininfo = UserLoginInfo::where('user_id',$user_id)->select('last_login_time','last_login_ip')->first()->toArray();
        return view('front.users.profile2',compact('info','logininfo','have_pass','apikey'));
    }

    public function changename(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:6|max:32|unique:users,name,' . Auth::id(),
        ]);
        $user_id = \Auth::id();
        $status = User::where('id',$user_id)->update(['name'=>$request->get('name')]);
        if($status) {
            return response()->json(['code'=>'200']);
        }else{
            return response()->json(['code'=>'400']);
        }
    }

    public function changepass(Request $request)
    {
        $this->validate($request,[
            'pass'      => 'required',
            'new_pass'  => 'required|confirmed',
        ]);
        $user_id = \Auth::id();
        $user_info = User::where('id',$user_id)->select('password')->first();
        if (Hash::check($request->get('pass'), $user_info->password)) {
            User::where('id',$user_id)->update(['password'=>bcrypt($request->get('new_pass'))]);
            return response()->json(['code'=>'200']);
        }else{
            return response()->json(['code'=>'400']);
        }
    }

    /**
     * @ 修改邮箱
     * @param email
     * @return 200 400
     */
    public function changeEmail(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|unique:users,email,'.\Auth::id()
        ]);
        $user = User::findOrFail(\Auth::id());

        if($user->email == $request->email) {
            return ['code'=>200];
        }

        $name  = $user->name;
        $token = str_random(60);

        Mail::send('email.resetEmail',['name'=>$name,'token'=>$token],function($message) use ($user){
            $message ->to($user->email)->subject('Confirmed Register Email');
        });
        if(!empty(Mail::failures())) {
            return ['code'=>10001]; //邮件发送失败
        }
        $user->confrimed_code = $token;
        $user->is_confrimed = 0;
        $user->email = $request->email;
        $user->save();
        $request->session()->flash('success','邮箱修改成功，请查收邮件');
        return ['code'=>200];
    }

    /**
     * @ 点击确认修改邮箱的操作链接
     * @param
     * @return
     */
    public function resetEmailconfrimedEmail($confrimed_code,Request $request)
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

    public function changepin(Request $request)
    {
        $this->validate($request,[
            'old_pin'       =>'required|string|min:8|max:20',
            'new_pin'       =>'required|string|min:8|max:20|confirmed',
        ]);
        $user_id = \Auth::id();
        $user_info = User::where('id',$user_id)->select('secpass')->first();
        if((!$user_info) || is_null($user_info->secpass)){
            return ['code'=>400,'message'=>'修改失败'];
        }
        if (Hash::check($request->get('old_pin'), $user_info->secpass)) {
            User::where('id',$user_id)->update(['secpass'=>bcrypt($request->get('new_pin'))]);
           /* $user_info->secpass = bcrypt($request->get('new_pin'));
            $user_info->save();*/
            return response()->json(['code'=>'200','message'=>'success']);
        }else{
            return response()->json(['code'=>'400','message'=>'old pin error']);
        }
    }

    public function setPin(Request $request)
    {
        $this->validate($request,[
            'pin'               => 'required|min:8|max:20|confirmed',
        ]);
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->select('id','secpass')->first();
        if(($user->secpass) || is_null($user)) {
            return ['code'=>400,'message'=>'设置失败'];
        }
        $user->secpass = bcrypt($request->get('pin'));
        $user->save();
        return ['code'=>200,'message'=>'设置成功'];
    }

    public function setApi(Request $request)
    {
        $this->validate($request,[
            'key'       => 'required|string|min:30',
            'secret'    => 'required|string|min:30',
        ]);
        $url = 'https://novaexchange.com/remote/v2/private/getbalance/BTC/';
        $result = $this->doConnectAPI($url,$request->get('key'),$request->get('secret'));
        $result = json_decode($result,true);
        if($result['status'] != 'success') {
            return ['code'=>404,'message'=>'无效的key或者secret'];
        }
        Apikey::updateOrCreate(['user_id'=>Auth::id()],[
            'key'=>encrypt($request->get('key')),
            'secret'=>encrypt($request->get('secret')),
        ]);
        return ['code'=>200,'message'=>'设置成功'];
    }

    public function dobcrypt()
    {
        $data = Apikey::all()->toArray();
    }

}

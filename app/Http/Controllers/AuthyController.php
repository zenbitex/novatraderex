<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Google;
use App\Models\User;
use App\Models\Authy;
use App\Models\User2faInfo;
use Illuminate\Http\Request;
use Authy\AuthyApi as AuthyApi;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class AuthyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>'']);
    }

    //2FA 主页
    public function index()
    {
        $info = User2faInfo::where('user_id',Auth::id())->get();
        if($info){
            $info = $info->toArray();
            $_2fa_type = array_column($info,'2fa_type');
            if(!in_array('3',$_2fa_type)) {
                //未设置Google Authenticator
                $createSecret = Google::CreateSecret();
                session(['secret'=>$createSecret['secret']]);
                session(['codeurl'=>$createSecret['codeurl']]);
            }
        }
        //返回用户的验证状态
        return view('front.security.index',compact('_2fa_type'));
    }

    //设置2FA
    public function setAuthy(Request $request)
    {
        $this->validate($request,[
            'region'    => 'required',
            'phone'     => 'required|integer',
        ]);

        $data            = request()->all();
        $data['user_id'] = \Auth::id();
        $data['region']  = substr($data['region'],1,strpos($data['region'],'(')-1);
        DB::beginTransaction();
        $authyApi = new \Authy\AuthyApi(env('AUTHY_API_KEY'));
        $user = User::where('id',Auth::id())->select('email')->firstOrFail();
        $authyUser = $authyApi->registerUser(
            $user->email,
            $request->phone,
            $data['region']
        );

        if ($authyUser->ok()) {
            Authy::create([
                'user_id'       => \Auth::id(),
                'country_code'  => $data['region'],
                'phone_number'  => $request->phone,
                'authy_id'      => bcrypt($authyUser->id()),
                'verified'      => 0
            ]);

            User2faInfo::create([
                'user_id'       => \Auth::id(),
                '2fa_type'      => 1
            ]);

            User::where('id',\Auth::id())->update(['is_2fa'=>1]);
            $request->session()->flash(
                'status',
                "Authy created successfully"
            );

            $sms = $authyApi->requestSms($authyUser->id());
            DB::commit();
            return ['code'=>200];
        } else {
            //$errors = $this->getAuthyErrors($authyUser->errors());
            DB::rollback();
            return ['code'=>400];
        }
    }

    //验证Authy
    public function checkAuthy(Request $request)
    {
        $this->validate($request,[
            'token' => 'required|integer',
        ]);
        $token = $request->token;
        $authyApi = new \Authy\AuthyApi(env('AUTHY_API_KEY'));
        $authyId = Authy::where('user_id',Auth::id())->value('authy_id');
        $verification = $authyApi->verifyToken($authyId, $token);
        if($verification->ok()){
            return ['code'=>200];
        }else{
            return ['code'=>400];
        }
    }

    public function showCheckAuthy()
    {
        return view('testCheckAuthy');
    }


}

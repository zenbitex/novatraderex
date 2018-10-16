<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Google;
use App\Models\User;
use App\Models\User2faInfo;
use App\Models\GoogleAuthenticator;
use Illuminate\Support\Facades\DB;

class GoogleAuthenticatorController extends Controller
{
    /*设置Google Authenticator*/
    public function setGoogleAuth(Request $request)
    {
        $this->validate($request,[
            'one'   =>  'required|integer',
            'two'   =>  'required|integer',
            'three' =>  'required|integer',
            'four'  =>  'required|integer',
            'five'  =>  'required|integer',
            'six'   =>  'required|integer'
        ]);

        $inputCode = $request->one.$request->two.$request->three.$request->four.$request->five.$request->six;
        if($this->checkNotSetGoogle($inputCode)) {
            //验证通过
            DB::beginTransaction();
            try{
                GoogleAuthenticator::updateOrCreate([
                    'user_id'   => \Auth::id()
                ],[
                    'google2fa_secret' => encrypt(session('secret'))
                ]);
                User2faInfo::create([
                    'user_id'       => \Auth::id(),
                    '2fa_type'      => 3
                ]);
                User::where('id',\Auth::id())->update(['is_2fa'=>1]);
                DB::commit();
                return ['code'=>200];
            } catch (Exception $e) {
                DB::rollback();
            }
        }
        return ['code'=>400];
    }

    public function checkGoogle($code)
    {
        if (empty($code) && strlen($code) != 6) return false;
        $google = decrypt(User::where('id',Auth::id())->value('google2fa_secret'));
        // 验证验证码和密钥是否相同
        if(Google::CheckCode($google['secret'],$code)) {
            return true;
        }else{
            return false;
        }
    }

    private function checkNotSetGoogle($code)
    {
        if (empty($code) && strlen($code) != 6) return false;
        $google = session('secret');
        // 验证验证码和密钥是否相同
        if(Google::CheckCode($google,$code)) {
            return true;
        }else{
            return false;
        }
    }

    //测试 Google Authenticator验证
    public function showCheck(Request $request)
    {
        if($request->isMethod('post')) {

        }
        return view('testCheckGoogleAuthenticator');
    }
}

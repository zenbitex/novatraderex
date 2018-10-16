<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Certification;
use Illuminate\Support\Facades\DB;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\AuthenticationRequest;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>'']);
    }

    //
    public function showAuthentication()
    {
        $is_certification = User::where('id',\Auth::id())->value('is_certification');
        if($is_certification == 0) {
            return view('front.users.authentication',compact('is_certification'));
        } else {
            $certificationInfo = Certification::where('user_id',\Auth::id())->firstOrFail();
            return view('front.users.authenticationed',compact('is_certification','certificationInfo'));
        }
    }

    public function setAuth(AuthenticationRequest $request,ImageUploadHandler $uploader)
    {
        $data = $request->all();
        if($request->photo) {
            $result = $uploader->save($request->photo,'uploads',Auth::id(),462);
            if($result) {
                $data['photo'] = $result['path'];
            }
        }
        $data['user_id'] = \Auth::id();
        $splitPhone      = splitPhone($data['phone']);
        $data['region']  = $splitPhone['region'];
        $data['phone']   = $splitPhone['phone'];
        DB::beginTransaction();
        try{
            $a = Certification::create($data);
            $b = User::where('id',\Auth::id())->update(['is_certification'=>1]);
        }catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('authentication')->with('danger','认证失败');
        }
        DB::commit();
        return redirect()->route('authentication')->with('success','认证资料上传成功，请耐心等待审核');
    }

    public function edit()
    {
        return view('front.users.authenticationEdit');
    }
}

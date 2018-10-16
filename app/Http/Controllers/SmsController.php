<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    //
    public function setSms(Request $request)
    {

        $this->validate($request,[
            'region'    => 'required',
            'phone'     => 'required|integer'
        ]);

        $data = $request->all();
        $data['region']  = substr($data['region'],1,strpos($data['region'],'(')-1);
        //TODO 发送验证码
    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
 * LangController处理设置语言
 * */
class LangController extends Controller
{
    public function setLocale($lang){
        if (array_key_exists($lang, config('app.locales'))) {
            session(['applocale' => $lang]);
        }
        return back()->withInput();
    }

}

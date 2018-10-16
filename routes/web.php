<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\User;
use App\Http\Middleware\CheckBind;
Route::get('blocktest','UserController@test');
Route::get('lang/{locale}', ['as'=>'lang.change', 'uses'=>'LangController@setLocale']);
Route::post('market/get24hInfo','CrontabController@get24hInfo')->name('get24hInfo');
Route::get('/','LoginController@index');
Route::post('market/api','MarketController@getApiData')->name('getApiData');
Route::post('market/order','MarketController@unCompeleteOrder')->name('getOrder');
Route::get('/cron','CrontabController@cron');
//Test
Route::get('/testa','MarketController@getBalacesByUser');
Route::get('/getReceiveHistory','CrontabController@getReceiveHistory');
//Test
/*Route::middleware(['checkbind'])->group(function () {*/
    Route::get('/wallets/balances','WalletController@index');
    Route::post('/wallet/withdraw','WalletController@doWithdraw');
    Route::get('/wallets/withdraw/history','WalletController@mywithdrawhistory');
    Route::post('/wallet/getaddress','WalletController@getaddress');
    Route::get('deposit/history','DepositController@getDepositHistory');
    Route::get('order/open','OrderController@myopenorders');
    Route::get('order/history','OrderController@history');
    Route::post('order/cancel','OrderController@cancel');
    Route::get('/trade','TradeController@index');
    Route::get('/market/{marketName}','MarketController@show')->where('marketName','[A-Z_a-z]+');
    Route::post('/market/trade','MarketController@doTrade');
    Route::post('market/axios/get_amount','MarketController@getAmount');
    Route::post('market/getTxFee','WalletController@getTxFee');
/*});*/

Route::get('verify/{token}','RegisterController@confrimedEmail');
Route::get('/reset/password/{token}/{time}/{sign}','LoginController@showResetPassword');
Route::post('/password/reset/{token}/{time}/{sign}','LoginController@resetPassword');
Route::post('/reset','LoginController@sendForgetEmail');
Route::get('/signup','RegisterController@register');
Route::post('/signup','RegisterController@store');
Route::get('/signin','LoginController@index')->name('login');
Route::get('/logout','LoginController@index');
Route::post('/signin','LoginController@login');
Route::get('/bind','UserController@bind');
Route::post('/bind','UserController@dobind');

Route::get('/test','RegisterController@test');

Route::get('/user/profile','UserController@profile')->name('profile');
Route::post('/user/changename','UserController@changename');
Route::post('/user/changepass','UserController@changepass');
Route::post('/user/changepin','UserController@changepin');
Route::post('/user/setpin','UserController@setPin');
Route::post('/user/setApi','UserController@setApi');
Route::post('/changeEmail','UserController@changeEmail')->name('changeEmail');
Route::get('resetemail/{token}','UserController@resetEmailconfrimedEmail');
Route::get('help',function(){
    return view('front.help');
});

Route::get('/authentication','AuthenticationController@showAuthentication')->name('authentication');
Route::post('/authentication/set','AuthenticationController@setAuth')->name('setAuthentication');
Route::get('/authentication/edit','AuthenticationController@edit')->name('editAuthentication');
//2fa Authy
Route::get('/2fa','AuthyController@index')->name('2fa');
Route::post('/setAuthy','AuthyController@setAuthy')->name('setAuthy');
Route::get('/checkAuthy','AuthyController@showCheckAuthy');
Route::post('/checkAuthy','AuthyController@checkAuthy')->name('checkAuthy');
//2fa SMS
Route::post('/setSMS','SmsController@setSms')->name('setSms');
//2fa Google Authenticator
Route::post('/setGoogle','GoogleAuthenticatorController@setGoogleAuth')->name('setGoogle');
Route::get('/checkGoogleAuth','GoogleAuthenticatorController@showCheck');
Route::post('/checkGoogleAuth','GoogleAuthenticatorController@showCheck')->name('checkGoogleAuth');

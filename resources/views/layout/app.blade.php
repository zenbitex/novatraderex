<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    @section('style')
        <link rel="stylesheet" href="{{ publicPath('front/css/base.css') }}">
        <link rel="stylesheet" href="{{ publicPath('front/lib/toastr.min.css') }}">
    @show
    {{--<link rel="stylesheet" href="{{ URL::asset('public/front/css/index.css') }}">--}}
</head>
<body>
<div id="wrap-header">
    <div class="header">
        <div class="logo"><img src="{{ publicPath('front/images/login/logo.png') }}" alt=""></div>
        <div class="right">
            <div class="nav">
                <ul>
                    <li><a href="{{url('/trade')}}"><span>TRADE</span></a></li>
                    <li class="btns">
                        <a><span class="dow">ORDERS</span></a>
                        <ul class="chil chil1">
                            <li><a href="{{url('order/open')}}"><span>OPEN ORDERS</span></a></li>
                            <li><a href="{{url('order/history')}}"><span>ORDERS HISTORY</span></a></li>
                        </ul>
                    </li>
                    <li class="btns">
                        <a><span class="dow">WALLET</span></a>
                        <ul class="chil chil2">
                            <li><a href="{{url('/wallets/balances')}}"><span>BALANCES</span></a></li>
                            <li><a href="{{url('/deposit/history')}}"><span>DEPOSIT HISTORY</span></a></li>
                            <li><a href="{{url('/wallets/withdraw/history')}}"><span>WITHDRAWAL HISTORY</span></a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('/help')}}"><span>HELP</span></a></li>
                    @if(Auth::check())
                        <li><a href="{{url('/logout')}} "><span>SIGN OUT</span></a></li>
                        @else
                        <li><a href="{{url('/signin')}} "><span>SIGN IN</span></a></li>
                    @endif
                </ul>
            </div>
            <div class="photo">
                <div class="profile_name"><a class="" href="{{url('user/profile')}}">@if(Auth::check()) {{Auth::user()->name}} @endif</a></div>
                <div class="guojia">
                    <div><a href="{{ route('lang.change', 'cn') }}"><img src="{{ publicPath('front/images/index/en.png') }}"></a></div>
                    <div><a href="{{ route('lang.change', 'zh_cn') }}"><img src="{{ publicPath('front/images/index/cn.png') }}"></a></div>
                    <div><a href="{{ route('lang.change', 'zh_tw') }}"><img src="{{ publicPath('front/images/index/cn2.png') }}"></a></div>
                </div>
            </div>
        </div>
    </div>
    <!--移动端头部-->
    <div id="hearter-phone" class="clear">
        <div class="fl leftbtn">
            <a><img width="22" height="17" src="{{ publicPath('front/images/common/left-btn.png') }}"></a>
        </div>
        <div class="fl rightlogo">
            <a href="index.html"><img src="{{ publicPath('front/images/common/logo.png') }}"></a>
        </div>
        <div class="listphon">
            <ul>
                <li class="activer"><a href=" ">PERSONAL</a></li>
                <li><a href="#">TRADE</a></li>
                <li>
                    <a class="down_1" href="#">ORDERS</a>
                    <ul class="down-nav a">
                        <li><a href="#">OPEN ORDERS</a></li>
                        <li><a href="#">ORDERS HISTORY</a></li>
                    </ul>
                </li>
                <li>
                    <a class="down_1" href="#">WALLET</a>
                    <ul class="down-nav b">
                        <li><a href="#">BALANCES</a></li>
                        <li><a href="#">DEPOSIT HISTORY</a></li>
                        <li><a href="#">WITHDRAWAL HISTORY</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">HELP</a>
                </li>
                <li>
                    <a href=" ">SIGN OUT</a>
                </li>
            </ul>
            <div class="phon-bottom">
                <div class="fl hengxian">
                    <a><img src="{{ publicPath('front/images/common/cn.jpg') }}"></a>
                </div>
                <div class="fl hengxian">
                    <a><img src="{{ publicPath('front/images/common/eg.jpg') }}"></a>
                </div>
                <div class="fl">
                    <a><img src="{{ publicPath('front/images/common/phon3.jpg') }}"></a>
                </div>
            </div>
        </div>
    </div>
    <!--移动端头部结束-->
</div>
@yield('content')
<div id="wrap-foot">
    <div class="foot">
        <div class="list">
            <a>API Documentation </a>
            <a>Terms and Conditions</a>
            <a>F.A.Q.</a>
            <a>Privacy Policy</a>
            <a>Contact NovaTraderex</a>
        </div>
        <div class="copy">
            © Copyright 2015-2017 NovaTraderex, Your crypto currency exchange by Nova Technology Limited.
        </div>
    </div>
</div>
<!--点击移动端按钮回到首页-->
<div id="backtop">
    <a><img src="{{ publicPath('front/images/common/backtop.png') }}"></a>
</div>
@section('script')
    <script src="{{ publicPath('front/lib/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ publicPath('front/js/auth.js') }}"></script>
    <script src="{{ publicPath('front/js/toastr.min.js') }}"></script>
@show
</body>
</html>
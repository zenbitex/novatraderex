<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>register</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/base.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/login.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/jquery.mCustomScrollbar.min.css') }}">
    <script src="{{ publicPath('front/lib/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body class="register">
<div class="header">
    <a href="javascript:;" class="logo">
        <img src="{{ publicPath('front/images/login/logo.png') }}" alt="">
    </a>
    <ul class="mobile-hidden">
        <li class="langular1"></li>
        <li class="langular2"></li>
        <li class="langular3"></li>
    </ul>
</div>
<div class="login-layer register-layer">
    <div class="langular large-hidden">
        <ul>
            <li class="langular1"></li>
            <li class="langular2"></li>
            <li class="langular3"></li>
        </ul>
    </div>
    <div class="layer-top">
        <div class="layer-content laydis">
            <h1>NovaTraderEx</h1>
            <a href="signin">SIGN IN</a>
        </div>
    </div>
    <div class="layer-cen">
        <div class="layer-form" id="registForm">
            <form id="regist" method="post" action="signup">
                {{csrf_field()}}
                <div class="layer-item">
                    <input type="text" class="layer-input" name="name" id="nickName" placeholder="Please Enter name"
                           value="{{old('name')}}">
                    <span class="tips">@if($errors->has('name')) {{ $errors->first('name') }} @endif</span>
                </div>
                <div class="layer-item">
                    <input type="text" class="layer-input" name="email" id="email" placeholder="Please Enter email"
                           value="{{old('email')}}">
                    <span class="tips">@if($errors->has('email')) {{ $errors->first('email') }} @endif</span>
                </div>
                <div class="layer-item">
                    <input type="text" class="layer-input" name="email_confirmation" id="emailAgiain"
                           placeholder="Please Enter email again" value="{{old('email_confirmation')}}">
                    <span class="tips">@if($errors->has('email')) {{ $errors->first('email') }} @endif</span>
                </div>
                <div class="layer-item">
                    <input type="password" class="layer-input" name="password" id="pwd"
                           placeholder="Please Enter the password">
                    <span class="tips">@if($errors->has('password')) {{ $errors->first('password') }} @endif</span>
                </div>
                <div class="layer-item">
                    <input type="password" class="layer-input" name="password_confirmation" id="pwdAgain"
                           placeholder="Please Enter the password again">
                    <span class="tips">@if($errors->has('password')) {{ $errors->first('password') }} @endif</span>
                </div>
                <div class="layer-item">
                    <div class="captcha_warp">
                        <input id="captcha" class="layer-input" name="captcha" type="text"placeholder="Please enter the verification code">
                        <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                    </div>
                    <span class="tips">
                                @if ($errors->has('captcha'))
                            {{ $errors->first('captcha') }}
                        @endif
                        </span>
                </div>
                <div class="layflex">
                    <label class="layer-deal" for="">
                        <input type="checkbox" id="check">
                        <a data-toggle="modal" data-target="#explain" href="javascript:;"
                           style="color: red;">Terms & Conditions I have read and agreed to the Privacy Policy </a>
                    </label>
                    <span class="tips"></span>
                </div>
            </form>
        </div>
    </div>
    <div class="layer-bottom">
        <button type="button" class="layer-btn" id="registerBtn">SIGN UP</button>
    </div>
</div>
<div class="footer">
    <div class="footer-wrapper">
        <ul class="footer-box">
            <li>
                <h2>FAL/USD</h2>

                <p class="footer-up">US$ 4,746. 30 <i class="ficon up"></i></p>

                <p class="footer-down">US$ 4,741. 97 <i class="ficon down"></i></p>
            </li>
            <li>
                <h2>FAL/USD</h2>

                <p class="footer-up">US$ 4,746. 30 <i class="ficon up"></i></p>

                <p class="footer-down">US$ 4,741. 97 <i class="ficon down"></i></p>
            </li>
            <li>
                <h2>FAL/USD</h2>

                <p class="footer-up">US$ 4,746. 30 <i class="ficon up"></i></p>

                <p class="footer-down">US$ 4,741. 97 <i class="ficon down"></i></p>
            </li>
            <li>
                <h2>FAL/USD</h2>

                <p class="footer-up">US$ 4,746. 30 <i class="ficon up"></i></p>

                <p class="footer-down">US$ 4,741. 97 <i class="ficon down"></i></p>
            </li>
            <li>
                <h2>FAL/USD</h2>

                <p class="footer-up">US$ 4,746. 30 <i class="ficon up"></i></p>

                <p class="footer-down">US$ 4,741. 97 <i class="ficon down"></i></p>
            </li>
        </ul>
    </div>
</div>
<div class="modal fade" id="explain" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Privacy Policy</h4>
            </div>
            <div class="modal-body">
                <div class="explain">
                    <div class="explain_content" style="font-size:14px;letter-spacing:1.2;text-align: justify">
                        Dooga Ltd. company number 4430228, whose registered office is 6 Agar Street, WC2N 4HN, London,
                        United Kingdom, trading as Cubits (We) are committed to protecting and respecting your privacy.
                        <br><br>
                        This policy (together with our terms of use and any other documents referred to herein) sets out
                        the basis on which any personal data we collect from you, or that you provide to us, will be
                        processed by us. Please read the following carefully to understand our practices in processing
                        your data, as well as your rights regarding your personal data and how we will treat it.
                        <br><br>
                        This policy (together with our terms of use and any other documents referred to herein) sets out
                        the basis on which any personal data we collect from you, or that you provide to us, will be
                        processed by us. Please read the following carefully to understand our practices in processing
                        your data, as well as your rights regarding your personal data and how we will treat it.
                        <br><br>
                        This policy (together with our terms of use and any other documents referred to herein) sets out
                        the basis on which any personal data we collect from you, or that you provide to us, will be
                        processed by us. Please read the following carefully to understand our practices in processing
                        your data, as well as your rights regarding your personal data and how we will treat it.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nov" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $(".explain").mCustomScrollbar({
            theme: 'dark'
        })
        $("#registForm .layer-item :input").blur(function () {
            $(this).next().removeClass("error").text("");
            if ($(this).is('#nickName')) {
                var uname = $(this).val();
                if (this.value == "") {
                    var onMessage = "Please enter your name";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if ($(this).is('#email')) {
                var email = $(this).val();
                var emailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if (this.value == '') {
                    var onMessage = "Please enter your email";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if (!emailReg.test(email)) {
                    var onMessage = "Please enter the correct mailbox";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if ($(this).is('#emailAgiain')) {
                var emailTwo = $(this).val();
                var emailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if (this.value == '') {
                    var onMessage = "Please enter your email";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if (!emailReg.test(emailTwo)) {
                    var onMessage = "Please enter the correct mailbox";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if (emailTwo != $('#email').val()) {
                    var onMessage = "Please enter the correct mailbox";
                    $(this).next().addClass("error").text(onMessage);
                }
                else {
                    $(this).next().removeClass("error").text('');
                }
            }
            if ($(this).is("#pwd")) {
                var pwd = $(this).val();
                var regExp = /^[a-zA-Z0-9!"\#$%&'()*+,-./:;<=>?@\[\\\]^_`\{\|\}\~]{6,18}$/;
                if (this.value == "") {
                    var onMessage = "Please enter your password";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if (!regExp.test(pwd)) {
                    var onMessage = "Incorrect password entry";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if ($(this).is("#pwdAgain")) {
                var repwd = $(this).val();
                if (this.value == "") {
                    var onMessage = "Please confirm the password.";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if (repwd != $("#pwd").val()) {
                    var onMessage = "The two passwords are inconsistent";
                    $(this).next().addClass("error").text(onMessage);
                }
                else {
                    $(this).next().removeClass("error").text("");
                }
            }
            if ($(this).is("#pin")) {
                if (this.value == "") {
                    var onMessage = "Please enter your Pin";
                    $(this).next().addClass("error").text(onMessage);
                } else if (this.value.length < 8 || this.value.length > 20) {
                    var onMessage = "Length can not be less than 8 bits, not more than 20 bits";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if ($(this).is("#pinAgain")) {
                if (this.value == "") {
                    var onMessage = "Please confirm the your Pin";
                    $(this).next().addClass("error").text(onMessage);
                }else if( $(this).val() != $("#pin").val() ) {
                    var onMessage = "The two Pin are inconsistent";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
        });
        $("#check").on('change', function () {
            if ($(this).attr('checked') == 'checked') {
                $(this).removeAttr('checked')
                $(this).parent().siblings().addClass('error').text('Please check the user agreement')
            } else {
                $(this).attr('checked', 'checked');
                $(this).parent().siblings().addClass('error').text('')
            }
        })
        $("#registerBtn").on('click', function () {
            $("#regist").submit();
            $("#registForm :input").trigger("blur");
            var numError = $("#registForm .error").length;
            if (numError) {
                return false;
            }
            if ($('#check').attr('checked') != 'checked') {
                $('#check').parent().siblings('span.tips').addClass('error').text('Please check the user agreement');
                return false;
            }
        })
    })
</script>
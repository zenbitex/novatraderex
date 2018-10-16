{{--<form action="/password/reset/{{$token}}/{{$time}}/{{$sign}}" method="post">
    {{csrf_field()}}
    邮箱：<br><input type="text" name="email"><br>
    新密码：<br><input type="password" name="password"><br>
    确认新密码：<br><input type="password" name="password_confirmation"><br>
    <input type="submit" value="提交">
</form>--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/base.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/password.css') }}">
</head>
<body>
<div class="header">
    <a href="javascript:;" class="logo">
        <img src="{{ publicPath('front/images/login/logo.png') }}" alt="">
    </a>
    <ul class="mobile-hidden">
        <li><a href="{{ url('/signup') }}"><span>SIGN UP</span></a></li>
        <li><a href="{{ url('/signin') }}"><span>SIGN IN</span></a></li>
    </ul>
</div>

<div id="wrap-contant">
    <div class="login-layer">
        <div class="layer-top">
            <div class="layer-content laydis">
                <h1>NovaTraderEx</h1>
                <!--<a href="javascript:;">SIGN UP</a>-->
            </div>
        </div>

        <div class="layer-cen">
            <form id="pass" action="/password/reset/{{$token}}/{{$time}}/{{$sign}}" method="post">
                {{csrf_field()}}
                <div class="layer-form" id="registForm">
                    <div class="layer-item">
                        <input type="text" class="layer-input" id="email" name="email"  placeholder="Please Enter E-mail">
                        <span class="tips error"></span>
                    </div>
                    <div class="layer-item">
                        <input type="passwork" class="layer-input" id="pwd" name="password" placeholder="Please Enter New Password">
                        <span class="tips"></span>
                    </div>
                    <div class="layer-item">
                        <input type="passwork" class="layer-input" id="pwdAgain" name="password_confirmation" placeholder="Please Confirm the new password">
                        <span class="tips"></span>
                    </div>
                </div>
            </form>
        </div>
        <div class="layer-bottom">
            <button type="button" class="layer-btn" id="LoginBtn">Submit</button>
        </div>
    </div>
</div>


<script src="{{ publicPath('front/lib/jquery-3.2.1.min.js') }}"></script>
<script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $("#registForm .layer-item :input").blur(function()
        {
            $(this).next().removeClass("error").text("");
            if( $(this).is('#email'))
            {
                var email = $(this).val();
                var emailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if(this.value == '')
                {
                    var onMessage = "Please enter your email";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if( !emailReg.test(email) )
                {
                    var onMessage = "Please enter the correct mailbox";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if( $(this).is("#pwd") )
            {
                var pwd = $(this).val();
                var regExp = /^[a-zA-Z0-9!"\#$%&'()*+,-./:;<=>?@\[\\\]^_`\{\|\}\~]{6,18}$/;
                if( this.value == "")
                {
                    var onMessage = "Please enter your password";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if( !regExp.test(pwd) )
                {
                    var onMessage = "Incorrect password entry";
                    $(this).next().addClass("error").text(onMessage);
                }
            }
            if( $(this).is("#pwdAgain") )
            {
                var repwd = $(this).val();
                if( this.value == "")
                {
                    var onMessage = "Please confirm the password.";
                    $(this).next().addClass("error").text(onMessage);
                }
                else if( repwd != $("#pwd").val() )
                {
                    var onMessage = "The two passwords are inconsistent";
                    $(this).next().addClass("error").text(onMessage);
                }
                else
                {
                    $(this).next().removeClass("error").text("");
                }
            }
            $('#LoginBtn').click(function() {
                $("#pass").submit()
            })
        })
    })
</script>
</body>
</html>

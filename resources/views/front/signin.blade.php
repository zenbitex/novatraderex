<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/base.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/login.css') }}">
    <script src="{{ publicPath('front/lib/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>
<div class="header">
    <a href="javascript:;" class="logo">
        <img src="{{ publicPath('front/images/login/logo.png') }}" alt="">
    </a>
    <ul class="mobile-hidden">
        <a href="{{ route('lang.change', 'cn') }}"><li class="langular1"></li></a>
        <a href="{{ route('lang.change', 'zh_cn') }}"><li class="langular2"></li></a>
        <a href="{{ route('lang.change', 'zh_tw') }}"><li class="langular3"></li></a>
    </ul>
</div>
<div class="login-layer">
    <div class="langular large-hidden">
        <ul>
            <a href="{{ route('lang.change', 'cn') }}"><li class="langular1"></li></a>
            <a href="{{ route('lang.change', 'zh_cn') }}"><li class="langular2"></li></a>
            <a href="{{ route('lang.change', 'zh_tw') }}"><li class="langular3"></li></a>
        </ul>
    </div>
    <div class="layer-top">
        <div class="layer-content laydis">
            <h1>NovaTraderEx</h1>
            <a href="{{ url('signup') }}">SIGN UP</a>
        </div>
    </div>
    <div class="layer-cen">
        <div class="layer-form" id="LoginForm">
            <form action="{{url('signin')}}" method="post" id="signin">
                {{csrf_field()}}
            <div class="layer-item">
                <input type="text" class="layer-input" id="iphone" name="email" placeholder="Please Enter Email" value="{{old('email')}}">
                <span class="tips error">@if($errors->has('email')) {{ $errors->first('email') }} @endif</span>
            </div>
            <div class="layer-item">
                <input type="password" class="layer-input" id="pwd" name="pwd" placeholder="Please Enter Password">
                <span class="tips error">
                    @if($errors->has('pwd'))
                        {{ $errors->first('pwd') }}
                    @elseif(Session::has('login_error_info'))
                        {{Session::get('login_error_info')}}
                    @elseif(Session::has('success'))
                        {{Session::get('success')}}
                    @endif
                </span>
            </div>
            <div class="layflex">
                <label class="layer-deal" for=""><input type="checkbox" checked="checked" id="check"><a href="javascript:;">Keep me signed in on this computer </a></label>
                <a data-toggle="modal" data-target="#forget_modal">Forget Password?</a>
                <span class="tips"></span>
            </div>
            </form>
        </div>
    </div>
    <div class="layer-bottom">
        <button type="button" class="layer-btn" id="LoginBtn">SIGN IN</button>
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

<!--forget password-->
<!--1-->
<div class="modal fade" id="forget_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Forget password</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="email" class="control-label">Email:</label>
                    <input type="text" class="form-control" id="forget_email" placeholder="Please enter the email">
                    <div class="alert alert-danger error">
                        <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span class="tips"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nov" data-toggle="modal" id="send_modal">OK</button>
                <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--2-->
<div class="modal fade" id="send_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Forget password</h4>
            </div>
            <div class="modal-body" style="font-size:20px;">
                <p>Your password reset link has been sent to <span id="send_to"></span> </p>
                <p>Plase check your settings yourself,Thank you!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nov" data-toggle="modal" data-target="#pass_modal">OK</button>
                <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--3-->
<div class="modal fade" id="{{--pass_modal--}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reset the password</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-group">
                        <label for="pass" class="control-label">password:</label>
                        <input type="password" class="form-control" id="pass" placeholder="Please enter the password">
                    </div>
                    <div class="form-group">
                        <label for="pass_end" class="control-label">password:</label>
                        <input type="password" class="form-control" id="pass_end" placeholder="Please enter the password again">
                    </div>
                </div>
                <div class="alert alert-danger error" id="send_pass_error">
                    <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <span class="tips"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button id="send_pass" type="button" class="btn btn-nov">OK</button>
                <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--4-->
<div class="modal fade" id="{{--succ_modal--}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> </h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <i class="font_succ"></i>
                <p>Password is set successfully</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nov">OK</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    /*
     *   js控制modal 显示隐藏     $("#succ_modal").modal('show')   hide
     * */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){
        function  checkpass(that,el) {
            that.parent().parent().next('.error').hide().find('.tips').text(" ");
            if(that.is(el)) {
                var pass = that.val();
                if(pass.length == 0) {
                    var onMessage = "Please input a password";
                    that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                }else if(pass.length != 0 && pass.length <4 || pass.length > 16) {
                    var onMessage = "Password length must not be less than 4 bits, not greater than 16 bits";
                    that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                }
            }
        }
        $("#pass").blur(function() {
            var that = $(this)
            checkpass(that,'#pass')
        })
        $("#pass_end").blur(function() {
            var that = $(this)
            checkpass(that,'#pass_end')
        })
        $("#send_pass").click(function() {
            if($("#pass").val() === $("#pass_end").val()) {
                $("#succ_modal").modal('show')
            }else{
                $("#pass").val("")
                $("#pass_end").val("")
                $("#send_pass_error").show().find('.tips').text("The password you entered two times is not the same")
            }
        })
        $("#email").blur(function () {
            $(this).next().hide().find('.tips').text(" ");
            if($(this).is("#email")) {
                var email = $(this).val();
                var reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
                if(this.value == "") {
                    var onMessage = "The mailbox you entered";
                    $(this).next().show().find('.tips').text(onMessage);
                }else if(!reg.test(email)) {
                    var onMessage = "The format you entered is incorrect";
                    $(this).next().show().find('.tips').text(onMessage);
                }
            }
        })
        $("#send_modal").unbind('click').bind('click',function () {
            $.ajax({
                url:'{{ url('/reset') }}',
                data:{'forget_email':$("#forget_email").val()},
                dataType:'json',
                type:'post',
                success:function (msg) {
                    if(msg.code == 200){
                        //toastr.success(msg.message);
                        $("#send_to").text($("#forget_email").val())
                        $("#send_modal").modal('show')
                    }else if(msg.code == 400){
                        toastr.error(msg.message);
                    }else if(msg.code == 404){
                        toastr.error(msg.error);
                    }
                },
                error:function (msg) {
                    toastr.error('error');
                }
            });
        });
        $("#LoginForm .layer-item :input").blur(function()
        {
            $(this).next().removeClass("error").text("");
            if( $(this).is("#iphone") )
            {
                var uname = $(this).val();
                var regExp = /^1[3|4|5|7|8]\d{9}$/;
                if( this.value == "")
                {
                    var onMessage = "Please enter your mobile number";
                    $(this).next().addClass("error").text(onMessage);
                }
//                else if( !regExp.test(uname) )
//                {
//                    var onMessage = "The phone number is incorrect";
//                    $(this).next().addClass("error").text(onMessage);
//                }
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
        }).keyup(function()
        {
            $(this).triggerHandler("blur");
        });
        $("#check").on('change',function(){
            if($(this).attr('checked') =='checked'){
                $(this).removeAttr('checked')
                $(this).parent().siblings('span.tips').addClass('error').text('Please check the user agreement');
            }else{
                $(this).attr('checked','checked');
                $(this).parent().siblings('span.tips').addClass('error').text('');
            }
        })
        $("#LoginBtn").on('click',function(){
            $("#LoginForm :input").trigger("blur");
            $('#check').next().text('Keep me signed in on this computer');//暂时性
            var numError = $("#LoginForm .error").length;
            if(numError){
                return false;
            }
            if($('#check').attr('checked') != 'checked'){
                $('#check').parent().siblings('span.tips').addClass('error').text('Please check the user agreement');
                return false;
            }
            $("#LoginBtn").attr("disabled", true);
            $("#signin").submit();
            //return;
            var iphone = $("#iphone").val();
            var pwd = $("#pwd").val();
            // $.ajax({
            //     type: "POST",
            //     url: "url",
            //     dataType: "json",
            //     async: true,
            //     data:{
            //         iphone: iphone,
            //         pwd: pwd,
            //     },
            //     success: function(arr)
            //     {
            //         //注册成功
            //     }
            // });
        })
    })
</script>
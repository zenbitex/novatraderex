@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/deposit.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/basic.css') }}">
@endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div class="bitcoin">
                <div class="magin0 basic">
                    <h4>Basic account information</h4>
                    <div class="b_content">
<<<<<<< HEAD:resources/views/front/profile.blade.php
                        {{--<div class="b_top">

                        </div>--}}
=======
                        <div class="b_top">
                        </div>
>>>>>>> staging:resources/views/front/users/profile.blade.php
                        <div class="b_info">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Name</li>
                                            <li id="newname"><span style="padding-right:12px;">{{$info['name']}}</span><i id="setName" class="glyphicon glyphicon-pencil"></i></li>
                                            <li></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>User ID</li>
                                            <li>{{$info['name']}}</li>
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>E-mail</li>
                                            <li>{{$info['email']}} &nbsp;<i id="setEmail" class="glyphicon glyphicon-pencil"></i></li>
                                            <li></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Login IP</li>
                                            <li>{{$logininfo['last_login_ip']}}</li>
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Password</li>
                                            <li>****** &nbsp;<i data-toggle="modal" data-target="#setPass" class="glyphicon glyphicon-pencil"></i></li>
                                            <li></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Last login</li>
                                            <li>{{$logininfo['last_login_time']}}</li>
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Pin</li>
                                            <li>****** &nbsp;<i {{--data-toggle="modal" data-target="#setPin"--}}  class="glyphicon glyphicon-pencil"></i></li>
                                            <li></li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>Registered</li>
                                            <li>{{$info['created_at']}}</li>
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul>
                                            <li></li>
                                            <li>API Keys</li>
                                            <li style="white-space:nowrap;text-overflow:hidden"><span style="padding-right:12px;">@if($apikey)*********@else 设置Apikeys @endif</span><i data-toggle="modal" data-target="#setApi"  class="glyphicon glyphicon-pencil"></i></li>
                                            <li></li>
                                        </ul>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <div class="modal fade" id="setPass" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change the password</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="pass" class="control-label">old password:</label>
                            <input type="password" class="form-control" id="pass" placeholder="Please enter the old password">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">new password:</label>
                            <input type="password" class="form-control" id="new_pass" placeholder="Please enter the new password">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">new password again:</label>
                            <input type="password" class="form-control" id="new_pass_confirmation" placeholder="Please enter the new password again">
                        </div>
                    </div>
                    <div class="alert alert-danger error" id="send_pass_error">
                        <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span class="tips"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nov" id="send_pass">OK</button>
                    <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--修改PIN-->
    <div class="modal fade" id="changePin" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change the pin</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="pass" class="control-label">pin:</label>
                            <input type="password" class="form-control" id="old_pin" placeholder="Please enter the old pin">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">new pin:</label>
                            <input type="password" class="form-control" id="new_pin" placeholder="Please enter the new pin">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">new pin again:</label>
                            <input type="password" class="form-control" id="new_pin_confirmation" placeholder="Please enter the new pin again">
                        </div>
                    </div>
                    <div class="alert alert-danger error" id="send_pin_error">
                        <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span class="tips"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nov" id="send_change_pin">OK</button>
                    <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--设置PIN-->
    <div class="modal fade" id="setPin" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Set the pin</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">pin:</label>
                            <input type="password" class="form-control" id="pin" placeholder="Please enter the new pin">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">pin again:</label>
                            <input type="password" class="form-control" id="pin_confirmation" placeholder="Please enter the new pin again">
                        </div>
                    </div>
                    <div class="alert alert-danger error" id="send_pin_error">
                        <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span class="tips"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nov" id="send_set_pin">OK</button>
                    <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 设置api-keys  -->
    <div class="modal fade" id="setApi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">set API Keys</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="pass" class="control-label">key:</label>
                            <input autocomplete="off" type="text" class="form-control" id="key" placeholder="Please enter the key">
                        </div>
                        <div class="form-group">
                            <label for="pass_end" class="control-label">secret:</label>
                            <input autocomplete="off" type="text" class="form-control" id="secret" placeholder="Please enter the secret">
                        </div>
                    </div>
                    <div class="alert alert-danger error" id="send_api_error">
                        <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <span class="tips"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nov" id="send_API_keys">OK</button>
                    <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" id="loading">
        <img width="80" height="80" src="{{ publicPath('front/images/index/loading.gif') }}" alt="">
    </div>
    @if (session('tips'))
        <input type="hidden" name="test" value="{{ session('tips') }}">
        @else
        aaaaaaaaaaaaaaaaaaa
    @endif

    @parent
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ publicPath('front/js/common.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            var secpass = '{{ $have_pass }}';

        })
        $(function() {
            /*密码验证*/
            function  checkpass(that,el) {
                that.parent().parent().next('.error').hide().find('.tips').text(" ");
                if(that.is(el)) {
                    var pass = that.val();
                    if(pass.length == 0) {
                        var onMessage = "Please input a password";
                        that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                    }else if(pass.length != 0 && pass.length <7 || pass.length > 16) {
                        var onMessage = "Password length must not be less than 8 bits, not greater than 16 bits";
                        that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                    }
                }
            }
            $("#pass").blur(function() {
                var that = $(this)
                checkpass(that,'#pass')
            })
            $("#new_pass_confirmation").blur(function() {
                var that = $(this)
                checkpass(that,'#new_pass_confirmation')
            })
            $("#send_pass").click(function() {
                if($("#new_pass").val() === $("#new_pass_confirmation").val()) {
                    $("#succ_modal").modal('show')
                }else{
                    $("#pass").val("")
                    $("#pass_confirmation").val("")
                    $("#send_pass_error").show().find('.tips').text("The password you entered two times is not the same")
                }
            })
            /*Pin验证*/
            function  checkpin(that,el) {
                that.parent().parent().next('.error').hide().find('.tips').text(" ");
                if(that.is(el)) {
                    var Pin = that.val();
                    if(Pin.length == 0) {
                        var onMessage = "Pin input Pin";
                        that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                    }else if(Pin.length != 0 && Pin.length <4 || Pin.length > 16) {
                        var onMessage = "Pin length must not be less than 4 bits, not greater than 16 bits";
                        that.parent().parent().next('.error').show().find('.tips').text(onMessage);
                    }
                }
            }
            $("#pin").blur(function() {
                var that = $(this)
                checkpin(that,'#pin')
            })
            $("#pin_end").blur(function() {
                var that = $(this)
                checkpin(that,'#pin_end')
            })
            $("#send_pin").click(function() {
                if($("#pin").val() === $("#pin_end").val()) {
                    $("#succ_modal").modal('show')
                }else{
                    $("#pin").val("")
                    $("#pin_end").val("")
                    $("#send_pin_error").show().find('.tips').text("The pin you entered two times is not the same")
                }
            })
            /*修改名字*/
            var flagName = false;
            var oldName = '';
            $("#setName").click(function() {
                oldName = $(this).siblings().text();
                $(this).hide();
                $(this).siblings().attr('contenteditable','true').focus().blur(function() {
                    if(flagName) {
                        return;
                    }
                    flagName = true;
                    var fullname = $(this).text();
                    if(fullname == oldName) {
                        $(this).keydown(function(e){
                            if(e.keyCode == 13) {
                                $(this).blur()
                            }
                        })
                        flagName = false;
                        $(this).attr('contenteditable','false').siblings('i').show();
                        return;
                    }
                    that = $(this);
                    $.ajax({
                        url:"{{url('user/changename')}}",
                        data:{'fullname':fullname},
                        type:'post',
                        datatype:'json',
                        success:function(msg) {
                            if(msg.code == 200){
                                flagName = false;
                                toastr.success('success!');
                            }else{
                                that.text(oldName)
                                flagName = false;
                                toastr.error('error!');
                            }
                        },
                        error:function (msg) {
                            that.text(oldName)
                            flagName = false;
                            var json=JSON.parse(msg.responseText);
                            toastr.error(json['errors']['fullname'])
                        }
                    });
                    $(this).attr('contenteditable','false').siblings('i').show();
                }).keydown(function(e) {
                    if(e.keyCode == 13) {
                        $(this).blur()
                    }
                })

            })
            /*修改邮箱*/
            $("#setEmail").click(function() {
                $(this).hide()
                $(this).parent().attr('contenteditable','true').focus().blur(function() {
                    /*
                     *   $(ajax)
                     * */
                    $(this).attr('contenteditable','false').find('i').show()
                })
            })
            /*修改密码*/
            $("#send_pass").click(function() {
                $.ajax({
                    url:"{{url('user/changepass')}}",
                    data:{'pass':$("#pass").val(), 'new_pass_confirmation':$("#new_pass_confirmation").val(),'new_pass':$('#new_pass').val()},
                    type:'post',
                    datatype:'json',
                    success:function(msg) {
                        if(msg.code == 200){
                            // TODO 关闭modal 提示成功
                            $("#setPass").modal('hide');
                            toastr.success('success!');
                            return;
                        }else{
                            // TODO  提示失败
                            toastr.error('error!');
                            return;
                        }
                    },
                    error:function (msg) {
                        var json=JSON.parse(msg.responseText);
                        // TODO  提示失败
//                        console.log(json['errors']['pass']);
                        toastr.error(json['errors']['pass']);
                    }
                });
            })
            /*修改pin*/
            $("#setPinClick").unbind('click').bind('click',function () {
                var secpass = "{{ $have_pass }}";
                if(secpass){
                    $("#changePin").modal('show')
                }else {
                    $("#setPin").modal('show')
                }
            });
            /*设置Pin*/
            $("#send_set_pin").unbind('click').on('click',function() {
                var pin = $("#pin").val();
                var pin_confirmation = $("#pin_confirmation").val();
                if(pin == '' || pin_confirmation == ''){
                    toastr.error('pin不能为空');
                }else if(pin != pin_confirmation) {
                    toastr.error('确认密码是否一致');
                }
                $.ajax({
                    url:"{{url('/user/setpin')}}",
                    data:{'pin':pin,'pin_confirmation':pin_confirmation},
                    dataType:'json',
                    type:'post',
                    success:function (msg) {
                        if(msg.code == 200){
                            toastr.success(msg.message);
                            $("#setPin").modal('hide')
                        }else if(msg.code == 400){
                            toastr.error(msg.message);
                        }
                    },
                    error:function (msg) {
                        var json=JSON.parse(msg.responseText);
                        toastr.error(json['errors']['pin']);
                    }
                });
            });
            /*修改pin*/
            $("#send_change_pin").unbind('click').on('click',function () {
                var old_pin = $("#old_pin").val();
                var new_pin = $("#new_pin").val();
                var new_pin_confirmation = $("#new_pin_confirmation").val();
                if(old_pin == ''){
                    toastr.error('请输入原始Pin');
                }else if(old_pin == ''){
                    toastr.error('请输入新Pin');
                }else if((new_pin_confirmation == '') || (new_pin != new_pin_confirmation)){
                    toastr.error('请确认新Pin');
                }
                $.ajax({
                    url:"{{url('user/changepin')}}",
                    data:{'old_pin':old_pin, 'new_pin':new_pin,'new_pin_confirmation':new_pin_confirmation},
                    type:'post',
                    datatype:'json',
                    success:function(msg) {
                        if(msg.code == 200){
                            // TODO 关闭modal 提示成功
                            $("#changePin").modal('hide')
                            toastr.success(msg.message);
                        }else if(msg.code == 400){
                            toastr.error(msg.message);
                        }
                    },
                    error:function (msg) {
                        var json=JSON.parse(msg.responseText);
                        // TODO  提示失败
                        if(json['errors']['old_pass'] != ''){
                            toastr.error(json['errors']['old_pin']);
                        }else if(json['errors']['new_pass'] != ''){
                            toastr.error(json['errors']['new_pin']);
                        }
                    }
                });
            });
            $("#send_pin").click(function() {

                $.ajax({
                    url:"{{url('user/changepin')}}",
                    data:{'old_pin':$("#old_pin").val(), 'new_pin':$("#new_pin").val(),'new_pin_confirmation':$("#new_pin_confirmation").val()},
                    type:'post',
                    datatype:'json',
                    success:function(msg) {
                        if(msg.code == 200){
                            // TODO 关闭modal 提示成功
                            $("#setPin").modal('hide')
                            toastr.success(msg.message);
//                            console.log('success');
                            return;
                        }else{
                            $("#loading").hide();
                            // TODO  提示失败
//                            console.log('error');
                            toastr.error(msg.message);
                            return;
                        }
                    },
                    error:function (msg) {
                        var json=JSON.parse(msg.responseText);
                        // TODO  提示失败
                        if(json['errors']['old_pass'] != ''){
                            toastr.error(json['errors']['old_pin']);
                        }else if(json['errors']['new_pass'] != ''){
                            toastr.error(json['errors']['new_pin']);
                        }
                    }
                });
            })
            //绑定API_KEYS
            $("#send_API_keys").click(function() {
                if($('#api').val() == '') {
                    $("#send_api_error").show().find('.tips').text('key')
                }
                if($('#secret').val() == '') {
                    $("#send_api_error").show().find('.tips').text('secret')
                }
                if($('#api').val() == '' && $('#secret').val() == '') {
                    $("#send_api_error").show().find('.tips').text('send_api_error')
                }
                $("#loading").show();
                $.ajax({
                    /*ajax*/
                    url: '{{ url('user/setApi') }}',
                    data:{'key':$("#key").val(), 'secret':$("#secret").val()},
                    type:'post',
                    datatype:'json',
                    success:function(msg) {
                        $("#loading").hide();
                        if(msg.code == 200){
                            $("#setApi").modal('hide')
                            toastr.success(msg.message);
                        }else{
                            toastr.error(msg.message);
                        }
                    },
                    error:function (msg) {
                        $("#loading").hide();
                        var json=JSON.parse(msg.responseText);
                        if(json['errors']['key'] != ''){
                            toastr.error(json['errors']['key']);
                        }else if(json['errors']['secret'] != ''){
                            toastr.error(json['errors']['secret']);
                        }
                    }
                })
            })
        })
    </script>
@endsection

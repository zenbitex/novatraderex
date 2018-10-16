@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ URL::asset('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('front/fonts/iconfont.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('front/css/basic.css') }}">
@endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div class="bitcoin">
                <div class="b_title">
                    <p>To ensure the security of transactions,protect your legitimate rights and interes,please complete your authentication!</p>
                    @include('layout._message')
                </div>
                <div class="magin0 fa_2" style="background:#f5f5f5;width: 1200px;margin: 0 auto">
                    <div class="b_info">
                        @include('layout._user_center_left_bar')
                        <div class="setting-rightinfo">
                            <div class="setting-panel">
                                <div class="safe-item authy">
                                    <i class="iconfont icon-yanzheng"></i>
                                    <p>Authy verification</p>
                                    @if(in_array('1',$_2fa_type))
                                        <div class="safe-item ID_card" style="border-bottom: 0">
                                                <a href="">已验证</a>
                                        </div>
                                    @else
                                        <button class="btn btn-nov set_btn">Set up</button>
                                    @endif
                                    <div class="mask"></div>
                                </div>
                                <div class="authy_info">
                                    <ul>
                                        <li>
                                            <div class="form-group">
                                                <label for="usertype">Region code</label>
                                                    <select class="form-control" name="authy_region" id="authy_region">
                                                        <option>+86(China)</option>
                                                        <option>1 American</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="p_number">Phone number</label>
                                                <input type="text" class="form-control" id="p_number" name="authy_phone" placeholder="">
                                            </div>
                                        </li>
                                        {{--<li>
                                            <div class="form-group">
                                                <label class="" for="p_code">Verification code</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control authy_code" id="p_code" placeholder="">
                                                    <div class="input-group-addon send_auth" id="auth_auth_send">Verification code</div>
                                                </div>
                                            </div>
                                        </li>--}}
                                        <li>
                                            <button class="btn btn-nov" id="authy_button">Verify and enable</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="safe-item sms">
                                    <i class="iconfont icon-duanxintubiao"></i>
                                    <p>SMS verification</p>
                                    <button class="btn btn-nov set_btn">Set up</button>
                                    <div class="mask"></div>
                                </div>
                                <div class="sms_info">
                                    <ul>
                                        <li>
                                            <div class="form-group">
                                                <label for="usertype">Region code</label>
                                                <select class="form-control" name="sms_region" id="sms_region">
                                                    <option>+86(China)</option>
                                                    <option>1 American</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="p_number">Phone number</label>
                                                <input type="text" class="form-control" id="sms_phone" name="sms_phone" placeholder="">
                                            </div>
                                        </li>
                                            <div class="form-group">
                                                <label class="" for="sms_code">Verification code</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control authy_code" id="sms_code" placeholder="">
                                                    <div class="input-group-addon send_sms" id="auth_sms_send">Send</div>
                                                </div>
                                            </div>
                                        <li>
                                            <button class="btn btn-nov" id="authy_button">Verify and enable</button>
                                        </li>l
                                    </ul>
                                </div>
                                <div class="safe-item google">
                                    <i class="iconfont icon-guge"></i>
                                    <p>Google Authenticator</p>
                                    @if(in_array('3',$_2fa_type))
                                        <div class="safe-item ID_card" style="border-bottom: 0">
                                            <a href="">已验证</a>
                                        </div>
                                    @else
                                    <button class="btn btn-nov set_btn">Set up</button>
                                    @endif
                                    <div class="mask"></div>
                                </div>
                                <div class="google_info">
                                    <div class="text">Please scan the QR code or manually enter the key, the mobile phone generated on the dynamic verification code to fill in the following input box</div>
                                    <div class="gg_qrcode_warp">
                                        <div class="gg_qrcode" id="gg_qrcode">
                                            {{--<img width="190" height="190" src="../images/basic/qr_code.jpg">--}}
                                        </div>
                                        <div class="gg_qrcode_tips">
                                            <div class="tips_info">
                                                <h4>How to install Google verification code?</h4>
                                                <p style="margin-top:10px;">iPhone Search the Google Authenticator Download App on the App Store Android Phone Search for "Google Authenticator" in the Android Market, or Search Google Authenticator Download Application
                                                </p>
                                                <p style="margin-top:10px;">After binding, login, withdraw, pay Google secondary verification required, <a href="javascript:;">see the detailed tutorial</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qrcode-text">Account Name: <span class="name">{{ config('google.authenticatorname') }}</span></div>
                                    <div class="qrcode-key">Key: <span class="key">
                                            @if(Session::has('secret'))
                                                {{ Session::get('secret') }}
                                            @endif</span></div>
                                    <div class="google_text">Google Verification Code</div>
                                    <form action="{{ route('setGoogle') }}" method="post">
                                        {{csrf_field()}}
                                    <div class="gg-code-input" id="qrcode">
                                        <input type="number" maxlength="1" name="qr_code_one" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                        <input type="number" maxlength="1" name="qr_code_two" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                        <input type="number" maxlength="1" name="qr_code_three" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                        <input type="number" maxlength="1" name="qr_code_four" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                        <input type="number" maxlength="1" name="qr_code_five" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                        <input type="number" maxlength="1" name="qr_code_six" class="gg-input" oninput="if(value.length>1)value=value.slice(0,1)">
                                    </div>
                                    <button class="btn btn-nov" id="setGoogle">Verify and enable</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ URL::asset('front/lib/jquery-3.2.1.min.js') }}"></script>
    {{--<script src="{{ URL::asset('front/js/auth.js') }}"></script> --}}
    <script src="{{ URL::asset('front/lib/jquery.qrcode.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            $('#gg_qrcode').qrcode('{{ Session::get('codeurl') }}');
        });
        $("#authy_button").unbind('click').bind('click',function() {
            var region = $("#authy_region option:selected").text();
            var phone = $("#p_number").val();
            if(region == ''){
                toastr.error('请选择region');
            }
            if(phone == ''){
                toastr.error('请输入phone');
            }
            $.ajax({
                url:"{{ route('setAuthy') }}",
                data:{'region':region,'phone':phone},
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
        });
        $("#auth_sms_send").unbind('click').on('click',function(e) {
            var sms_region = $("#sms_region").val();
            var sms_phone = $("#sms_phone").val();
            if((sms_region == '') || (sms_phone == '')) {
                toastr.error('请输入手机号');
            }
            $.ajax({
                url:"{{ route('setSms') }}",
                data:{'region':sms_region,'phone':sms_phone},
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
        });
        $("#setGoogle").unbind('click').on('click',function (e) {
            e.preventDefault();
            var one = $("input[name=qr_code_one]").val();
            var two = $("input[name=qr_code_two]").val();
            var three = $("input[name=qr_code_three]").val();
            var four = $("input[name=qr_code_four]").val();
            var five = $("input[name=qr_code_five]").val();
            var six = $("input[name=qr_code_six]").val();
            if((one == '' ) || (two == '')|| (three == '')|| (four == '')|| (five == '')|| (six == '')){
                toastr.error('请输入Google Verification Code');
            }
            $.ajax({
                url:"{{ route('setGoogle') }}",
                data:{'one':one,'two':two,'three':three,'four':four,'five':five,'six':six},
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
        });
    </script>
@endsection
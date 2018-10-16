<!--弹框添加充值-->
<div class="modal fade" id="explain" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: hidden">
            <div class="modal-header" style="background: #f0f0f0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deposit Bitcoin(<span class="withdraw_currency"></span>)</h4>
            </div>
            <div class="modal-body">
                <div class="explain">
                    <div class="explain_content" style="font-size:14px;letter-spacing:1px;">
                        <span>Deposit address:</span>
                        <div style="text-align: center; margin-bottom: 34px;">
                            <a style="height:38px; line-height: 38px; display: inline-block; border: 1px solid #e6e6e6; padding: 0 50px; " class="modal_address"></a>
                            <div style="height: 60px; line-height: 60px; color: #989898; font-size: 12px;">*Verify that above text is the same as the image below.*</div>
                            <input style="font-size: 18px;width:80%;text-align: center" id="modal_address" readonly value=""><br>
                            <button type="button" id="copy" class="btn  btn-lg" onclick="copyText(modal_address)" style="background: #3377ff; color: #fff; margin-top: 32px;">Copy address</button>
                        </div>
                        <span>Deposit QR code:</span>
                        <div style=" margin-top: 32px; text-align: center;">
                            <div style="border:8px solid #e6e6e6; display: inline-block; " id="qrcode"></div><br>
                            <a style=" height: 52px; line-height: 52px; display: inline-block;">Scan QR code to deposit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <!--<button type="button" class="btn btn-nov" >OK</button>-->
                <button type="button" class="btn btn-nov" data-dismiss="modal" style="background: #3377ff; color: #fff;">Close</button>
            </div>
        </div>
    </div>
</div>

<!--弹框添加取款-->
<div class="modal fade" id="qukuan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 680px;">
        <div class="modal-content" style="overflow: hidden">
            <div class="modal-header" style="background: #f0f0f0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Withdraw Bitcoin(<span class="withdraw_currency"></span>)</h4>
            </div>
            <div class="modal-body">
                <div class="explain">
                    <div class="explain_content" style="font-size:14px;letter-spacing:1px;">
                        <p style="color:#666666; font-size: 12px; height: 48px; line-height: 48px; margin-top:4px; ">
                            This currency does not count to your daily withdrawal limit.You may freely withdraw any amount.
                        </p>
                        <div>
                            <span style=" font-size: 16px; ">Withdraw address:</span><br>
                            <input style="border: 1px solid #ccc; margin: 10px 0; text-indent: 10px; border-radius:6px; height: 42px; line-height: 42px; width: 100%;" type="text" placeholder="Withdraw Bitcoin address" id="withdrawAddress"><br><br>
                            <span style=" font-size: 16px; padding-top: 14px; ">Withdraw amount:</span><br>
                            <input style="border: 1px solid #ccc; margin: 10px 0; text-indent: 10px; border-radius:6px; height: 42px; line-height: 42px; width: 100%;"  type="text" placeholder="0.00000000" id="withdrawAmount" id="withdrawAmount"><br>
                            <div  style=" font-size: 16px;">Max: <a style="color: #3377ff" id="maxvalue">0.00000000</a></div><br>
                            <span  style=" font-size: 16px;">Transaction fee:</span><br>
                            <input style="border: 1px solid #ccc; background: #e6e6e6; margin: 10px 0; text-indent: 10px; border-radius:6px; height: 42px; line-height: 42px; width: 100%;"  type="text" value="" id="withdrawFee" disabled='disabled'><br>
                            <span  style=" font-size: 16px;">Pin:</span><br>
                            <input style="border: 1px solid #ccc; margin: 10px 0; text-indent: 10px; border-radius:6px; height: 42px; line-height: 42px; width: 100%;"  type="text" placeholder="Please enter pin" id="withdrawPin"><br>
                            @if(count($_2fa_info) > 0)
                                <span  style=" font-size: 16px;">2FA:</span><br>
                                <select name="2fa" id="2fa" style="border: 1px solid #ccc; margin: 10px 0; text-indent: 10px; border-radius:6px; height: 42px; line-height: 42px; width: 30%;">
                                @foreach($_2fa_info as $fa)
                                        <option value="{{$fa}}">{{ get2faType($fa) }}</option>
                                @endforeach
                                </select>
                            @else
                                <p class="text-danger">{{ trans('profile.authTips') }}</p>
                            @endif
                        </div>
                        <!--错误提示-->
                        {{--<div style="background:#ffcccc; padding-left: 10px; border-radius: 2px; height: 42px; line-height: 42px; color:#cc2929;  "><a style="width: 22px; height: 22px; line-height: 22px; margin-right: 8px; display: inline-block; border-radius: 50%; background: #cc2929; color: #ffcccc; font-size: 18px;  font-weight: bold; text-align: center;">×</a>Withdraw failure! please enter again!</div>--}}
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none; margin-bottom: 20px;">
                <!--如果取款成功data-toggle="modal" data-target="#success"弹出成功框-->
                <!--如果取款失败不添加data-toggle="modal" data-target="#success"显示错误提示-->
                    <button type="button" class="btn btn-nov" id="dowithdraw" data-toggle="modal" style="background: #3377ff; color: #fff;" >Withdraw Bitcoin(<span class="withdraw_currency"></span>)</button>
                <button type="button" class="btn btn-nov" data-dismiss="modal" style="background: #3377ff; color: #fff;">Close</button>
            </div>
        </div>
    </div>
</div>

<!--弹框取款成功-->
<div class="modal fade" id="success" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="explain">
                    <div class="explain_content" style="letter-spacing:1px; text-align: center; margin-top: 20px;
">
                        <a style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%; text-align: center; display: inline-block; background:#29cc29; color: #fff; font-size:30px; font-weight: bolder;  ">√</a>
                        <div style="margin-top: 46px; color: #666; font-size:20px; ">Withdraw success</div>
                        <span style="margin-top: 24px; display: inline-block; color: #666;">Please check email</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none; margin-bottom: 20px; text-align: center;">
                <button type="button" class="btn btn-nov" data-dismiss="modal" style="background: #3377ff; color: #fff; font-size: 20px; padding: 6px 20px;"> OK </button>
            </div>
        </div>
    </div>
</div>
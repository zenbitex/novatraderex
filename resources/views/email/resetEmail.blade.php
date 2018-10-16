@extends('layout._email')
@section('content')
    <td class="textContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;background-color:#ffffff" valign="top">
        <div style="box-sizing: border-box; margin: 0px 0px 10px; font-family: 'Microsoft YaHei', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px;">
            <p>尊敬的用户：{{ $name  or 'User'}}</p>
            <p>您好！</p>
            <p style="height:20px;">&nbsp;</p>
            <p>您刚刚操作了修改邮箱，请点击以下链接完成修改，否则账号无法登陆：<a href="http://novatraderex.dev/verify/{{$token or 'xx'}}" style="display:inline-block;max-width:560px!important;word-break:break-all" target="_blank">http://novatraderex.dev/resetemail/{{$token or 'xxx'}}</a></p>
        </div>
    </td>
@endsection
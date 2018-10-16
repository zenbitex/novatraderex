<div class="setting-leftmenu">
    <div class="menu-head"><i class="iconfont icon-gerenzhongxin"></i>User Center</div>
    <div class="menu-c">
        <div class="menu-title">User information</div>
        <div class="menu-item-cont">
            <a href="{{ route('profile') }}" class="menu-item ">Basic information</a>
            <a href="{{ route('authentication') }}" class="menu-item active">Authentication</a>
        </div>
    </div>
    <div class="menu-c bt">
        <div class="menu-title">Account security</div>
        <div class="menu-item-cont">
            <a href=" {{ route('2fa') }}" class="menu-item ">2FA</a>
        </div>
    </div>
</div>
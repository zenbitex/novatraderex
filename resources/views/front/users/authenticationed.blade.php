@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/fonts/iconfont.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/basic.css') }}">
@endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div class="bitcoin">
                <div class="b_title">
                    <p>To ensure the security of transactions,protect your legitimate rights and interes,please complete your authentication!</p>
                    @include('layout._message')
                </div>
                <div class="magin0 auth" style="background:#f5f5f5;width: 1200px;margin: 0 auto">
                    <div class="b_info">
                        @include('layout._user_center_left_bar')
                        <div class="setting-rightinfo">
                            <div class="setting-panel">
                                <div class="safe-item ID_card">
                                    <i class="iconfont icon-shenfenzheng"></i>
                                    <p>Mainland China ID card</p>
                                    <a href="">
                                        @if($is_certification)
                                            待审核
                                        @else
                                            未验证
                                        @endif
                                    </a>
                                </div>
                                    <div class="id_card_info">
                                        <ul>
                                            <li>
                                                <div class="form-group">
                                                    <label for="a_name">Actual name</label>
                                                    {{  $certificationInfo->fullname  }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group">
                                                    <label for="id_card">ID card</label>
                                                    {{ $certificationInfo->identity }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    {{ $certificationInfo->address }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group">
                                                    <label for="p_num">Phone number</label>
                                                    {{ $certificationInfo->region }}-{{ $certificationInfo->phone }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group">
                                                    <label for="d_birth">Date of birth</label>
                                                    {{ $certificationInfo->birth }}
                                                </div>
                                            </li>
                                            @if (count($errors) > 0)
                                                <li>
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="passport_info">
                                        <div class="passport_phone">
                                            <div class="phone">
                                                <img src="{{ $certificationInfo->photo }}" alt="">
                                            </div>
                                            {{--<button id="auth_sub" class="btn btn-nov">Edit</button>--}}
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div></div></div>
@endsection
@section('script')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /*$("#auth_sub").click(function(e) {
            e.preventDefault();
            window.location.href = "{{ route('editAuthentication',Auth::id()) }}";
        });*/
    </script>
@endsection
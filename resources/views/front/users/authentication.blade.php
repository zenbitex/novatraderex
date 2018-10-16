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
                    <form action="{{ route('setAuthentication', Auth::id()) }}" method="POST"
                          accept-charset="UTF-8"
                          enctype="multipart/form-data" id="myForm">
                        {{  csrf_field() }}
                    <div class="id_card_info">
                        <ul>
                            <li>
                                <div class="form-group">
                                    <label for="a_name">Actual name</label>
                                    <input type="text" class="form-control" id="a_name" placeholder="" name="fullname" value="{{ old('fullname') }}">
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="id_card">ID card</label>
                                    <input type="text" class="form-control" id="id_card" placeholder="" name="identity" value="{{ old('identity') }}">
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="" name="address" value="{{ old('address') }}">
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="p_num">Phone number</label>
                                    <input type="text" class="form-control" id="p_num" placeholder="{{trans('region')}}-{{trans('phone')}}" name="phone" value="{{ old('phone') }}">
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <label for="d_birth">Date of birth</label>
                                    <input type="date" class="form-control" id="d_birth" placeholder="" name="birth" value="{{ old('birth') }}">
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
                    <div class="safe-item passport">
                        <i class="iconfont icon-huzhao"></i>
                        <p>ID card/Passport</p>
                        <a href="">
                            @if($is_certification)
                                待审核
                            @else
                                未验证
                            @endif
                        </a>
                    </div>
                    <div class="passport_info">
                        <div class="passport_phone">
                            <div class="phone">
                                <img id="img_id" class="phone_box" src=""></img>
                                <div class="images_upload">
                                    <input type="file" id="image_upload" name="photo" accept="image/bmp,image/png,image/jpeg,image/jpg,image/gif" id="image_upload" style="display: none;" >
                                    <label for="image_upload"></label>
                                    <i class="iconfont icon-shangchuanzhaopian"></i>
                                    <p>Upload photos</p>
                                </div>
                            </div>
                            <button id="auth_sub" class="btn btn-nov">Submit</button>
                        </div>
                        <div class="passport_tips">
                            <h4>Please upload your ID card or passport, picture is less than 2M</h4>
                            <ul>
                                <li>Upload pictures Note:</li>
                                <li>Your upload of ID card or passport images is real and effective</li>
                                <li>The information of your ID card or passport picture is clearly visible</li>
                                <li>There are no reflections or creases on your uploaded images</li>
                                <li>The picture you uploaded is a color image</li>
                            </ul>
                        </div>
                    </div>
                    </form>
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

        $("#image_upload").on('change',function () {
            var imgFile = $("#image_upload")[0].files[0];
            var reader=new FileReader();
            reader.readAsDataURL(imgFile);
            reader.onload =function (e){
                $("#img_id").attr('src',this.result)
            }
        })

        $("#auth_sub").click(function(e) {
            e.preventDefault();
            var fullname = $("#fullname").val();
            var identity = $("#identity").val();
            var address = $("#address").val();
            var phone = $("#p_num").val();
            var birth = $("#d_birth").val();
            if(fullname == ''){
                toastr.error('name');
            }
            if(identity == ''){
                toastr.error('name');
            }
            if(address == ''){

            }
            if(phone == ''){

            }
            /*re = /^[0-9]{1,6}-[0-9]{5,11}$/;
            if(!re.test(phone)){
                toastr.error('please enter phone');
            }*/
            if(birth == ''){
                toastr.error('name');
            }
            $("#myForm").submit();
            if((name !== '') && (idCard !== '') && (address !== '') && (phone !== '') && (birth !== '')) {

            }
        });
    </script>
@endsection
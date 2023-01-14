@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
             <div class="account-wrapper mw-100 bg--glass">
                <form class="account-form row" method="post" action="">
                    @csrf
                    <div class="cmn--form--group form-group">
                        <label for="current_password" class="cmn--label text--white w-100">@lang('Current Password')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                                <i class="las la-unlock-alt"></i>
                            </span>
                            </div>
                            <input type="password" class="form-control cmn--form--control" id="current_password" name="current_password" required="" placeholder="@lang('Current Password')">
                        </div>
                    </div>

                     <div class="cmn--form--group form-group">
                        <label for="password" class="cmn--label text--white w-100">@lang('Password')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                                <i class="las la-lock"></i>
                            </span>
                            </div>
                            <input type="password" class="form-control cmn--form--control" id="password" name="password" required="" placeholder="@lang('Password')">
                        </div>
                         @if($general->secure_password)
                            <div class="progress mt-4">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <p class="text-danger my-1 capital">@lang('Minimum 1 capital letter is required')</p>
                            <p class="text-danger my-1 number">@lang('Minimum 1 number is required')</p>
                            <p class="text-danger my-1 special">@lang('Minimum 1 special character is required')</p>
                        @endif
                    </div>

                   

                    <div class="cmn--form--group form-group">
                        <label for="password_confirmation" class="cmn--label text--white w-100">@lang('Confirm Password')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                                <i class="las la-key"></i>
                            </span>
                            </div>
                            <input type="password" class="form-control cmn--form--control" id="password_confirmation" name="password_confirmation" required="" placeholder="@lang('Confirm Password')">
                        </div>
                    </div>
                    
                    <div class="cmn--form--group form-group col-md-12 text-end mb-0">
                        <button type="submit" class="cmn--btn btn-block">@lang('Change Password')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
      "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                var password = $(this).val();
                var width = 25;
                var capital = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
                var capital = capital.test(password);
                if (!capital){
                    $('.capital').removeClass('d-none');
                }else{
                    width += 25;
                    $('.capital').addClass('d-none');
                }
                var number = /[123456790]/;
                var number = number.test(password);
                if (!number){
                    $('.number').removeClass('d-none');
                }else{
                    width += 25;
                    $('.number').addClass('d-none');
                }
                var special = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                var special = special.test(password);
                if (!special){
                    $('.special').removeClass('d-none');
                }else{
                    width += 25;
                    $('.special').addClass('d-none');
                }
                if (width == 25) {
                    var bg = 'red';
                    var msg = 'Too Week'
                }else if(width == 50){
                    var msg = 'Week'
                    var bg = '#D7A612';
                }else if(width == 75){
                    var msg = 'Medium'
                    var bg = '#5210BF';
                }else if(width == 100){
                    var msg = 'Strong'
                    var bg = 'green';
                }
                $('.progress-bar').attr('style',`width:${width}%;background:${bg};`);
                $('.progress-bar').text(msg);
            });
        @endif
    </script>
@endpush
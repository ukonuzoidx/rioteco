@extends($activeTemplate.'layouts.auth')
@section('content')
<div class="account-section pt-120 pb-120">
    <div class="container">
        <div class="account-wrapper bg--section">
            <div class="account-logo">
                <a href="{{route('home')}}">
                    <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')">
                </a>
            </div>
            <h4 class="text-center">@lang('Reset Password')</h4>
            <form class="account-form" method="POST" action="{{ route('user.password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
               
                <div class="cmn--form--group form-group">
                    <label for="password" class="cmn--label text--white w-100">@lang('Password')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                                <i class="las la-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control cmn--form--control" name="password" id="password" placeholder="@lang('Password')" required="" autocomplete="new-password">
                    </div>
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

                <div class="cmn--form--group form-group mt-2">
                    <label for="password" class="cmn--label text--white w-100">@lang('Confirm Password')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                               <i class="las la-unlock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control cmn--form--control" name="password_confirmation" id="password" placeholder="@lang('Confirm Password')" required="" autocomplete="new-password">
                    </div>
                </div>

                <div class="cmn--form--group form-group">
                    <button type="submit" class="cmn--btn">@lang('Reset Password')</button>
                </div>
            </form>
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

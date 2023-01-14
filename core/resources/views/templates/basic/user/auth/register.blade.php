@extends($activeTemplate.'layouts.auth')
@section('content')
<div class="account-section pt-120 pb-120">
    <div class="container">
        <div class="account-wrapper bg--section mw-100">
            <div class="account-logo">
                <a href="{{route('home')}}">
                    <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')">
                </a>
            </div>
            <form class="account-form row" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                @csrf

                @if(session()->get('reference') != null)
                    <div class="cmn--form--group form-group">
                        <label for="referenceBy" class="cmn--label text--white w-100">@lang('Reference By')</label>
                        <input type="text" name="referBy" id="referenceBy" class="form-control cmn--form--control" value="{{session()->get('reference')}}" readonly>
                    </div>
                @endif


                <div class="cmn--form--group form-group col-md-6">
                    <label for="firstname" class="cmn--label text--white w-100">@lang('First Name')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                            <i class="las la-user"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control cmn--form--control" name="firstname" value="{{old('firstname')}}" id="firstname" placeholder="@lang('First Name')" required="">
                    </div>
                </div>

                <div class="cmn--form--group form-group col-md-6">
                    <label for="lastname" class="cmn--label text--white w-100">@lang('Last Name')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                           <i class="las la-user-alt"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control cmn--form--control" name="lastname" value="{{old('lastname')}}" id="lastname" placeholder="@lang('Last Name')" required="">
                    </div>
                </div>

                <div class="cmn--form--group form-group col-md-6">
                    <label for="username" class="cmn--label text--white w-100">@lang('Username')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                           <i class="las la-user-circle"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control cmn--form--control" name="username" value="{{old('username')}}" id="username" placeholder="@lang('Username')" required="">
                    </div>
                </div>


                <div class="cmn--form--group form-group col-md-6">
                    <label for="email" class="cmn--label text--white w-100">@lang('E-Mail Address')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                           <i class="las la-envelope"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control cmn--form--control" name="email" id="email" value="{{old('email')}}" placeholder="@lang('E-Mail Address')" required="">
                    </div>
                </div>


                <div class="cmn--form--group form-group col-md-6">
                    <label for="phone" class="cmn--label text--white w-100">@lang('Phone Number')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100 p-0">
                           <select name="country_code" class="h-100 border-0 px-2">
                                @include('partials.country_code')
                            </select>
                        </span>
                        </div>
                        <input type="text" name="mobile" class="form-control cmn--form--control" value="{{old('phone')}}"  id="phone" placeholder="@lang('Phone Number')" required="">
                    </div>
                </div>
                

                <div class="cmn--form--group form-group col-md-6">
                    <label for="country" class="cmn--label text--white w-100">@lang('Country')</label>
                    <div class="input-group">
                        <div class="input-group-prepend ">
                            <span class="input-group-text h-100">
                                <i class="las la-globe"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control cmn--form--control" name="country" id="country" placeholder="@lang('Country')" required="" readonly="">
                    </div>
                </div>


                <div class="cmn--form--group form-group col-md-6">
                    <label for="password" class="cmn--label text--white w-100">@lang('Password')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                            <i class="las la-lock"></i>
                        </span>
                        </div>
                        <input type="password" class="form-control cmn--form--control" id="password" name="password" placeholder="@lang('Password')" required="">
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

                <div class="cmn--form--group form-group col-md-6">
                    <label for="password" class="cmn--label text--white w-100">@lang('Confirm Password')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text h-100">
                            <i class="las la-lock-open"></i>
                        </span>
                        </div>
                        <input type="password" class="form-control cmn--form--control" id="password" name="password_confirmation" placeholder="@lang('Confirm Password')" required="">
                    </div>
                </div>

                @include($activeTemplate.'partials.custom-captcha')

                <div class="cmn--form--group form-group">
                    @php echo recaptcha() @endphp
                </div>

                <div class="text--white col-md-12">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="checkgroup text--white d-flex align-items-center">
                            <input type="checkbox" class="border-0 form--checkbox" id="remember-me" name="terms" required="">
                            <label for="remember-me" class="m-0 pl-2">@lang('I accept all terms & conditions')</label>
                        </div>

                        <div>
                            @lang('Already have an account') ? <a href="{{route('user.login')}}" class="text--base">@lang('Sign In')</a>
                        </div>
                    </div>
                </div>

                <div class="cmn--form--group form-group col-md-12 mt-2">
                    <button type="submit" class="cmn--btn">@lang('Sign Up')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('style')
<style type="text/css">
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush

@push('script')
    <script>
      "use strict";
      @if($country_code)
        $(`option[data-code={{ $country_code }}]`).attr('selected','');
      @endif
        $('select[name=country_code]').change(function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }

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

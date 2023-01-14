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
                <h4 class="text-center p-2">@lang('Sign In')</h4>
                <form class="account-form" method="POST" action="{{ route('user.login')}}"
                              onsubmit="return submitUserForm();">
                @csrf
                    <div class="cmn--form--group form-group">
                        <label for="username" class="cmn--label text--white w-100">@lang('Username')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text h-100">
                                    <i class="las la-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control cmn--form--control" name="username" value="{{old('username')}}" id="username" placeholder="@lang('Username')" required="">
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
                            <input type="password" class="form-control cmn--form--control" name="password" id="password" placeholder="@lang('Password')" required="" autocomplete="current-password">
                        </div>
                    </div>

                    @include($activeTemplate.'partials.custom-captcha')

                    <div class="cmn--form--group form-group">
                        @php echo recaptcha() @endphp
                    </div>

                    <div class="cmn--form--group form-group">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class=" text--white d-flex align-items-center">
                                <a href="{{route('user.password.request')}}" class="text--info">@lang('Forget Password') ?</a>
                            </div>
                            <div class="text--white">
                                @lang("Don't have an account") ? <a href="{{route('user.register')}}" class="text--base">@lang("Create Account")</a>
                            </div>
                        </div>
                    </div>

                    <div class="cmn--form--group form-group">
                        <button type="submit" class="cmn--btn">@lang('Sign In')</button>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
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
    </script>
@endpush

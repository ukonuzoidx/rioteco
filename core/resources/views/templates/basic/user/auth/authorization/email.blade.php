@extends($activeTemplate .'layouts.auth')
@section('content')
    <div class="account-section pt-120 pb-120">
        <div class="container">
            <div class="account-wrapper bg--section">
                <div class="account-logo">
                    <a href="{{route('home')}}">
                        <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')">
                    </a>
                </div>
                <form class="account-form" method="POST" action="{{route('user.verify_email')}}">
                    @csrf
                    <h4 class="text-center">@lang('Please Verify Your Email to Get Access')</h4>
                    <h6 class="text-center mt-1">@lang('Email') : {{auth()->user()->email}}</h6>
                    <div class="cmn--form--group form-group mt-2">
                         <div id="phoneInput">
                            <div class="field-wrapper">
                                <div class=" phone">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                    <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cmn--form--group form-group  text-center">
                        <button type="submit" class="cmn--btn">@lang('Submit') <i class="las la-sign-in-alt"></i></button>
                    </div>

                    <div class="cmn--form--group form-group  text-center">
                        <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{route('user.send_verify_code')}}?type=email" class="forget-pass"> @lang('Resend code')</a></p>
                        @if ($errors->has('resend'))
                            <br/>
                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{asset('assets/js/jquery.inputLettering.js') }}"></script>
@endpush
@push('style')
    <style>
        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
        }
        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }
        #phoneInput .letter {
            height: 50px;
            border-radius: 0;
            text-align: center;
            max-width: calc((100% / 10) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
            border: 1px solid #0e0d35;
        }
        #phoneInput .letter + .letter {
        }

        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }

            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        $(function () {
            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
                onLetterKeyup: function ($item, event) {
                    console.log('$item:', $item);
                    console.log('event:', event);
                },
                onSet: function ($el, event, value) {
                    console.log('element:', $el);
                    console.log('event:', event);
                    console.log('value:', value);
                }
            });
        });
    </script>
@endpush
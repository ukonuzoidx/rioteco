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
                <h4 class="text-center m-2">@lang('Forgot Password')</h4>
                <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                    @csrf
                    <div class="cmn--form--group form-group">
                        <div class="input-group">
                            <label class="cmn--label text--white w-100">@lang('Select One')</label>
                            <div class="input-group-prepend">
                            <span class="input-group-text h-100">
                                <i class="las la-language"></i>
                            </span>
                            </div>
                            <select class="form-control cmn--form--control" name="type">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                    </div>

                     <div class="cmn--form--group form-group">
                        <label for="value" class="cmn--label text--white w-100 my_value"></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text h-100">
                                    <i class="las la-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control cmn--form--control" id="value" name="value">
                        </div>
                    </div>
                    
                    <div class="cmn--form--group form-group">
                        <button type="submit" class="cmn--btn">@lang('Send Password Code')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  Account Section  -->
@endsection
@push('script')
<script>
    "use strict";
    $('select[name=type]').change(function(){
        $('.my_value').text($('select[name=type] :selected').text());
    }).change();
</script>
@endpush
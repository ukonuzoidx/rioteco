<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('partials.seo')
    <title>{{ $general->sitename($page_title ?? '') }}</title>
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'frontend/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'frontend/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'frontend/css/main.css')}}">
    <link rel="shortcut icon" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" type="@lang('Image')">
    @stack('style-lib')
    @stack('style')

    <link href="{{ asset($activeTemplateTrue . 'frontend/css/color.php') }}?color={{$general->base_color}}" rel="stylesheet" />
</head>

<body>
    @php echo fbcomment() @endphp
    <a href="javascript:void(0)" class="scrollToTop"><i class="las la-angle-up"></i></a>
    <div class="overlay"></div>

    <div class="preloader">
        <div class="loader">
            <span><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}"></span>
        </div>
    </div>

    @include($activeTemplate . 'partials.header')

    @yield('content')


    @php
        $content = getContent('call.content', true);
    @endphp
    @if(@$content)
    <div class="call-to-action bg--base pt-50 pb-50">
        <div class="container">
            <div class="call-to-wrapper p-0">
                <h4 class="title text--dark">{{__(@$content->data_values->heading)}}</h4>
                <div class="call-to-btn">
                    <a href="{{__(@$content->data_values->button_url)}}" class="cmn--btn text--black bg--white border-0">{{__(@$content->data_values->button_name)}}</a>
                </div>
            </div>
        </div>
    </div>
    @endif


    @include($activeTemplate . 'partials.footer')

    <script src="{{asset($activeTemplateTrue . 'frontend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/lightbox.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/raf-scroll.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'frontend/js/main.js')}}"></script>

    @stack('script-lib')
    @stack('script')
    @include('partials.plugins')
    @include('admin.partials.notify')

    <script src="{{asset($activeTemplateTrue .'frontend/js/sfx-widget.js')}}"></script>
    <script>
        "use strict";
        (function ($) {
            $(document).on("change", ".langSel", function() {
                window.location.href = "{{url('/')}}/change/"+$(this).val() ;
            });
        })(jQuery);
    </script>
</body>
</html>

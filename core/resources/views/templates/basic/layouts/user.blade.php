<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('partials.seo')
    <title>{{ $general->sitename($page_title ?? '') }}</title>
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'user/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'user/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'user/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue .'user/css/main.css')}}">
    <link rel="shortcut icon" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" type="@lang('Image')">
     <link href="{{ asset($activeTemplateTrue . 'frontend/css/color.php') }}?color={{$general->base_color}}" rel="stylesheet" />
    @stack('style-lib')
    @stack('style')
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

    @include($activeTemplate . 'partials.user_header')

    @yield('content')

    @include($activeTemplate . 'partials.footer')

    <script src="{{asset($activeTemplateTrue . 'user/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/lightbox.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/raf-scroll.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue . 'user/js/main.js')}}"></script>

    @stack('script-lib')
    @stack('script')
    @include('partials.plugins')
    @include('admin.partials.notify')

    <script src="{{asset($activeTemplateTrue .'user/js/sfx-widget.js')}}"></script>
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

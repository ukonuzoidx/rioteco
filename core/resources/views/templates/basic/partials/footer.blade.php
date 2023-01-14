@php
    $content = getContent('footer.content', true);
    $footer_menu = getContent('footer.element', false);
    $subscribe = getContent('subscribe.content', true);
    $contact = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
@endphp
    <footer class="footer-section">
        <div class="footer-top pt-120 pb-120">
            <div class="container">
                <div class="row gy-5 justify-content-between">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer__widget">
                            <a href="{{route('home')}}" class="logo">
                                <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')">
                            </a>
                            <p>
                                {{__(@$content->data_values->heading)}}
                            </p>
                            <ul class="post__share">
                                @forelse($socialIcons as $value)
                                    <li>
                                        <a href="{{$value->data_values->url}}" target="__blank">
                                           @php echo $value->data_values->social_icon @endphp
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="footer__widget">
                            <h5 class="title">@lang('Promotions')</h5>
                            <ul class="widget__links">
                                @forelse($footer_menu as $value)
                                  <li><a href="{{route('footer.menu', [str_slug($value->data_values->menu), $value->id])}}">{{$value->data_values->menu}}</a></li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer__widget">
                            <h5 class="title">@lang('Useful Links')</h5>
                            <ul class="useful__links">
                                <li>
                                    <a href="{{route('home')}}">@lang('Home')</a>
                                </li>

                                @foreach($pages as $k => $data)
                                    <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                                @endforeach
                                <li>
                                    <a href="{{route('user.login')}}">@lang('Sign In')</a>
                                </li>
                                <li>
                                    <a href="{{route('user.register')}}">@lang('Sign Up')</a>
                                </li>

                                 <li>
                                    <a href="{{route('contact')}}">@lang('Contact')</a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer__widget">
                            <h5 class="title">@lang('Our Newsletter')</h5>
                            <p>{{__(@$subscribe->data_values->heading)}}</p>
                            <form class="subscribe-form">
                                <input type="email" value="" id="emailSub" class="form-control subscribe--form--control" name="email" placeholder="@lang('Your Email Address')">
                                <button type="button" class="cmn--btn"><i class="lab la-telegram-plane subscribe-btn"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle">
            <div class="container">
                <div class="footer-middle-wrapper">
                    <div class="row g-0">
                        <div class="col-lg-4">
                            <div class="footer__contact__item">
                                <div class="footer__contact__thumb">
                                    <i class="las la-envelope-open-text"></i>
                                </div>
                                <div class="footer__contact__content">
                                    <h6 class="footer__contact__title">
                                        <a href="mailto:{{@$contact->data_values->email_address}}">{{__(@$contact->data_values->email_address)}}</a>
                                    </h6>
                                    <span class="info">@lang('Email Address')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="footer__contact__item">
                                <div class="footer__contact__thumb">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="footer__contact__content">
                                    <h6 class="footer__contact__title">
                                        <a href="Tel:{{@$contact->data_values->contact_number}}">{{__(@$contact->data_values->contact_number)}}</a>
                                    </h6>
                                    <span class="info">@lang('Call Us Now')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="footer__contact__item">
                                <div class="footer__contact__thumb">
                                    <i class="las la-map-marked-alt"></i>
                                </div>
                                <div class="footer__contact__content">
                                    <h6 class="footer__contact__title">
                                        <a href="javascript:void(0)">{{__(@$contact->data_values->contact_details)}}</a>
                                    </h6>
                                    <span class="info">@lang('Our Address')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                &copy; @lang('All Right Reserved by') <a href="{{route('home')}}" class="text--base">{{__($general->sitename)}}</a>
            </div>
        </div>
    </footer>

@push('script')
<script>
'use strict';
    $(document).on('click','.subscribe-btn' , function(){
        var email = $("#emailSub").val();
        if(email)
        {
            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('subscribe') }}",
                method:"POST",
                data:{email:email},
                success:function(response)
                {
                    if(response.success) {
                        notify('success', response.success);
                    }else{
                        notify('error', response.error)
                    }
                }
            });
        }
        else
        {
            notify('error', "Please Input Your Email");
        }
    });
</script>
@endpush



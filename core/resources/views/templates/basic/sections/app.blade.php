@php
    $content = getContent('app.content', true);
@endphp
    <section class="app-section overflow-hidden pt-120 pb-120">
        <div class="container">
            <div class="row align-items-center justify-content-between gy-5">
                <div class="col-lg-6 col-xl-5">
                    <div class="app-thumb rtl">
                        <img src="{{ getImage('assets/images/frontend/app/'. @$content->data_values->background_image, '735x640')}}" alt="@lang('app')">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="app-content">
                        <div class="section__header section__header__left">
                            <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
                            <p>
                                {{__(@$content->data_values->sub_heading)}}
                            </p>
                        </div>
                        <div class="couple--buttons">
                            <a href="{{__(@$content->data_values->first_url)}}" target="__blank">
                                <img src="{{asset($activeTemplateTrue .'frontend/images/app/google-play.svg')}}" alt="@lang('app')">
                            </a>
                            <a href="{{__(@$content->data_values->second_url)}}" target="__blank">
                                <img src="{{asset($activeTemplateTrue .'frontend/images/app/app-store-btn.svg')}}" alt="@lang('app')">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

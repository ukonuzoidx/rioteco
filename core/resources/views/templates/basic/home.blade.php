@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $content = getContent('banner.content', true);
    $elements = getContent('banner.element', false, 4);
@endphp
    <section class="banner-section bg--overlay bg_img" data-background="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->background_image, '1000x562')}}">
        <div class="container">
            <div class="banner-wrapper">
                <div class="banner-content mt-xl-5">
                    <h2 class="banner-title">{{__(@$content->data_values->heading)}}</h2>
                    <p class="banner-text">
                        {{__(@$content->data_values->sub_heading)}}
                    </p>
                    <a href="{{__(@$content->data_values->button_)}}" class="cmn--btn">{{__(@$content->data_values->button_name)}}</a>
                </div>
                <div class="banner-thumb">
                    <img src="{{ getImage('assets/images/frontend/banner/'. @$content->data_values->hero_image, '989x862')}}" alt="@lang('banner')">
                    <div class="banner-anime-thumbs">
                    @forelse($elements as $value)
                        <div class="banner-anime banner-anime{{$loop->iteration}}">
                            <img src="{{ getImage('assets/images/frontend/banner/'. @$value->data_values->background_image, '71x186')}}" alt="@lang('banner')">
                        </div>
                    @empty
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif
@endsection

@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
   <section class="blog-section bg--section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center g-4">
            @forelse($blogs as $value)
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post__item">
                        <div class="post__thumb">
                            <a href="{{ route('blog.details', [$value->id, str_slug($value->data_values->title)]) }}">
                                <img src="{{ getImage('assets/images/frontend/blog/'. $value->data_values->blog_image_1, '728x465')}}" alt="@lang('blog')">
                            </a>
                        </div>
                        <div class="post__content">
                            <h6 class="post__title">
                                <a href="{{ route('blog.details', [$value->id, str_slug($value->data_values->title)]) }}">{{__($value->data_values->title)}}</a>
                            </h6>
                            <div class="meta__date">
                                <div class="meta__item">
                                    <i class="las la-calendar"></i>
                                    {{showDateTime($value->created_at,'d M Y')}}
                                </div>
                                <div class="meta__item">
                                    <i class="las la-user"></i>
                                    @lang('Admin')
                                </div>
                            </div>
                            <a href="{{ route('blog.details', [$value->id, str_slug($value->data_values->title)]) }}" class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
            </div>
             {{paginateLinks($blogs) }}
        </div>
    </section>
@endsection

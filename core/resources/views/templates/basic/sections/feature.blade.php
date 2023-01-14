@php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', false, 6);
@endphp



<section class="feature-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="section__header">
            <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="row g-4">
            @foreach($elements as $value)
                <div class="col-md-6 col-lg-4">
                    <div class="feature__item">
                        <div class="feature__thumb">
                            @php echo $value->data_values->feature_icon @endphp
                        </div>
                        <div class="feature__content">
                            <h6 class="feature__title">{{__(@$value->data_values->title)}}</h6>
                            <p>{{__(@$value->data_values->short_details)}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>




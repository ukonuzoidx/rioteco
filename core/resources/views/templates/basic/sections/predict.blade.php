@php
    $content = getContent('predict.content', true);
    $elements = getContent('predict.element', false, 6);
@endphp
<section class="predict-type-section pb-120 pt-120">
    <div class="container">
        <div class="row gy-5">
            <div class="section__header">
                <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
                <p>
                    {{__(@$content->data_values->sub_heading)}}
                </p>
            </div>
        </div>
        <div class="row g-xl-2 g-lg-4 g-md-2 g-3">
            @forelse($elements as $value)
                <div class="col-xl-2 col-md-3 col-sm-6 ">
                    <div class="predict-type-item predictModelShow" data-bs-toggle="modal"
                         data-bs-target="#predictModelShow" data-title="{{$value->data_values->title}}"
                         data-description="{{$value->data_values->description}}"
                         data-button_name="{{__(@$value->data_values->button_name)}}"
                         data-button_url="{{__(@$value->data_values->button_url)}}">
                        <div class="icon">
                            @php echo $value->data_values->icon @endphp
                        </div>
                        <span class="title">{{__(@$value->data_values->title)}}</span>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>

<div class="modal fade custom--modal" id="predictModel">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title modelTitle"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="predict-type-content">
                    <p class="text-white description">

                    </p>
                    <div class="pt-2 d-flex flex-wrap couple--buttons">
                        <a href="{{@$value->data_values->button_name}}" class="cmn--btn btn_name"></a>
                        <a href="{{route('user.register')}}" class="cmn--outline--btn">@lang('Sign Up Now')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        'use strict';
        $('.predictModelShow').on('click', function () {
            var modal = $('#predictModel');
            modal.find('.modelTitle').text($(this).data('title'));
            modal.find('.description').text($(this).data('description'));
            modal.find('.btn_name').text($(this).data('button_name'));
            modal.find('.btn_name').attr("href", $(this).data('button_url'));
            modal.modal('show');
        });
    </script>
@endpush

@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead>
                        <tr>
                            <th>@lang('Transaction ID')</th>
                            <th>@lang('Gateway')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('After Charge')</th>
                            <th>@lang('Rate')</th>
                            <th>@lang('Receivable')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Time')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                    <td data-label="@lang('Gateway')">{{ __($data->method->name) }}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')" class="text-danger">
                                        {{getAmount($data->charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('After Charge')">
                                        {{getAmount($data->after_charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Rate')">
                                        {{getAmount($data->rate)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="@lang('Receivable')" class="text-success">
                                        <strong>{{getAmount($data->final_amount)}} {{__($data->currency)}}</strong>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($data->status == 2)
                                            <span class="badge badge--primary">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge badge--success">@lang('Completed')</span>
                                            <button class="btn-info btn-rounded  badge approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                        @elseif($data->status == 3)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                            <button class="btn btn-info approveBtn text-white" data-admin_feedback="{{$data->admin_feedback}}"><i class="las la-info-circle"></i></button>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Time')">
                                        <i class="fa fa-calendar"></i>{{showDateTime($data->created_at)}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>
            {{paginateLinks($withdraws) }}
        </div>
    </div>
</div>

<div class="modal fade custom--modal" id="detailModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Details')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="withdraw-detail"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="cmn--btn btn--sm text--white btn--danger" data-bs-dismiss="modal">@lang('Close')</button>

            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    "use strict";
    $('.approveBtn').on('click', function() {
        var modal = $('#detailModal');
        var feedback = $(this).data('admin_feedback');

        modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
        modal.modal('show');
    });
</script>
@endpush

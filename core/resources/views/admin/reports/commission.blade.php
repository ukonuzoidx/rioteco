@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('From Username')</th>
                                <th scope="col">@lang('TRX')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Post Balance')</th>
                                <th scope="col">@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($commissions as $value)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($value->created_at) }}</td>
                                    <td data-label="@lang('Username')">
                                        <a href="{{ route('admin.users.detail', $value->user_id) }}">{{ @$value->user->username }}</a>
                                    </td>
                                     <td data-label="@lang('From Username')">
                                        <a href="{{ route('admin.users.detail', $value->from_user_id) }}">{{ @$value->fromUser->username }}</a>
                                    </td>
                                    <td data-label="@lang('TRX')">{{ $value->trx }}</td>
                                    <td data-label="@lang('Amount')">
                                        {{getAmount($value->amount)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Post Balance')">{{ getAmount($value->post_balance) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Detail')">{{ __($value->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($commissions) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form action="{{route('admin.report.commission.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username / From Username')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush



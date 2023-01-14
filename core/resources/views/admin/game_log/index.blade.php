@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Crypto Currency')</th>
                                <th scope="col">@lang('Crypto Symbol')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('In Time')</th>
                                <th scope="col">@lang('HighLow')</th>
                                <th scope="col">@lang('Result')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gamelogs as $gamelog)
                            <tr>
                                <td data-label="@lang('ID')">{{__($loop->iteration)}}</td>
                                <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $gamelog->user_id) }}">{{ $gamelog->user->username }}</a></td>
                                <td data-label="@lang('Crypto Currency')" class="text-uppercase">{{__($gamelog->crypto->name)}}</td>
                                <td data-label="@lang('Crypto Symbol')" class="text-uppercase">{{__($gamelog->crypto->symbol)}}</td>
                                <td data-label="@lang('Amount')">{{__(getAmount($gamelog->amount))}} {{$general->cur_text}}</td>
                                <td data-label="@lang('In Time')">{{showDateTime($gamelog->in_time, 'd M, Y h:i:s')}}</td>
                                <td data-label="@lang('High Low')">
                                    @if($gamelog->hilow == 1)
                                        <span class="badge badge--success">@lang('High')</span>
                                    @elseif($gamelog->hilow == 2)
                                        <span class="badge badge--danger">@lang('Low')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Result')">
                                    @if($gamelog->result == 1)
                                        <span class="badge badge--success">@lang('Win')</span>
                                    @elseif($gamelog->result == 2)
                                        <span class="badge badge--danger">@lang('Lose')</span>
                                    @elseif($gamelog->result == 3)
                                        <span class="badge badge--warning">@lang('Draw')</span>
                                    @else
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($gamelog->status == 0)
                                        <span class="badge badge--primary">@lang('Running')</span>
                                    @elseif($gamelog->status == 1)
                                        <span class="badge badge--success">@lang('Complete')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Date')">{{showDateTime($gamelog->created_at, 'd M, Y h:i:s')}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($gamelogs) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins') 
    <form action=" {{route('admin.game.log.search', $scope ?? str_replace('admin.game.log.', '', request()->route()->getName()))}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username / Crypto Currency')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

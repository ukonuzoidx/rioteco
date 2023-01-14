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
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Unit')</th>
                                <th scope="col">@lang('Created Date')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($games as $game)
                            <tr>
                                <td data-label="@lang('ID')">{{__($loop->iteration )}}</td>
                                <td data-label="@lang('Time')">{{__($game->time)}}</td>
                                <td data-label="@lang('Unit')" class="text-uppercase">{{__($game->unit)}}</td>
                                <td data-label="@lang('Created Date')">{{__(showDateTime($game->created_at, 'd M Y'))}}</td>
                                <td data-label="@lang('Action')">
                                    <button class="icon-btn btn--primary updateGame" data-id="{{$game->id}}" data-time="{{$game->time}}" data-unit="{{$game->unit}}"><i class="las la-edit"></i></button>
                                    <button class="icon-btn btn--danger deleteGame" data-id="{{$game->id}}"><i class="las la-trash-alt"></i></button>
                                </td>
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
                    {{paginateLinks($games) }}
                </div>
            </div>
        </div>
    </div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Trade Setting')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.game.store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="time" class="form-control-label font-weight-bold">@lang('Time')</label>
                        <input type="text" class="form-control" id="time" name="time" value="{{old('time')}}" placeholder="@lang('Time')" required>
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-control-label font-weight-bold">@lang('Unit')</label>
                        <select class="form-control" id="unit" name="unit" required="">
                            <option value="">---@lang('Select Unit')---</option>
                            <option value="seconds">@lang('Seconds')</option>
                            <option value="minutes">@lang('Minutes')</option>
                            <option value="hours">@lang('Hours')</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Update Trade Setting')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.game.update')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="time" class="form-control-label font-weight-bold">@lang('Time')</label>
                        <input type="text" class="form-control" id="time" name="time" value="" placeholder="@lang('Time')" required>
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-control-label font-weight-bold">@lang('Unit')</label>
                        <select class="form-control" id="unit" name="unit" required="">
                            <option>---@lang('Select Unit')---</option>
                            <option value="seconds">@lang('Seconds')</option>
                            <option value="minutes">@lang('Minutes')</option>
                            <option value="hours">@lang('Hours')</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.game.delete')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure want to delete this gameing time')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
   <button type="button" class="btn btn--primary box--shadow1 text--small addCurrency">@lang('Add New')<button>
@endpush

@push('script')
<script>
    'use strict';
        $('.addCurrency').on('click', function () {
            var modal = $('#addModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.deleteGame').on('click', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
        
        $('.updateGame').on('click', function () {
            var modal = $('#updateModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=time]').val($(this).data('time'));
            modal.find('select[name=unit]').val($(this).data('unit'));
            modal.modal('show');
        });
</script>
@endpush


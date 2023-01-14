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
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Coin Symbol')</th>
                                <th scope="col">@lang('Created Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cryptos as $crypto)
                            <tr>
                                <td data-label="@lang('Name')">
                                    <div class="user">
                                        <div class="thumb">
                                            <img src="{{getImage('assets/images/cryptoCurrency/'. $crypto->image, '800x800')}}" alt="@lang('image')">
                                        </div>
                                        <span class="name">{{__($crypto->name)}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Coin Symbol')">{{__($crypto->symbol)}}</td>
                                <td data-label="@lang('Created Date')">{{__(showDateTime($crypto->created_at, 'd M Y'))}}</td>
                                <td data-label="@lang('Status')">
                                    @if($crypto->status == 0)
                                        <span class="badge badge--danger">@lang('Disable')</span>
                                    @elseif($crypto->status == 1)
                                        <span class="badge badge--success">@lang('Enable')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <button class="icon-btn btn--primary updateCurrency" data-id="{{$crypto->id}}" data-name="{{$crypto->name}}" data-symbol="{{$crypto->symbol}}" data-status="{{$crypto->status}}"><i class="las la-edit"></i></button>
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
                    {{ paginateLinks($cryptos) }}
                </div>
            </div>
        </div>
    </div>

    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Crypto Currency')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.crypto.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control" id="name" maxlength="80" name="name" value="{{old('name')}}" placeholder="@lang('Name')" required>
                        </div>

                        <div class="form-group">
                            <label for="symbol" class="form-control-label font-weight-bold">@lang('Symbol')</label>
                            <input type="text" class="form-control" id="symbol" maxlength="30" name="symbol" value="{{old('symbol')}}" placeholder="@lang('Symbol')" required>
                        </div>

                        <div class="form-group">
                            <label for="symbol" class="form-control-label font-weight-bold">@lang('Image')</label>
                            <div class="custom-file">
                              <input type="file" name="image" class="custom-file-input" id="customFileLangHTML" required="">
                              <label class="custom-file-label" for="customFileLangHTML" data-browse="@lang('Choose Image')">@lang('Crypto Currency Image')</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                   data-toggle="toggle" data-on="Enable" data-off="Disable" name="status">
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
                <h5 class="modal-title">@lang('Update Crypto Currency')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.crypto.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-control-label font-weight-bold">@lang('Name')</label>
                        <input type="text" class="form-control" id="name" maxlength="80" name="name" value="" placeholder="@lang('Name')" required>
                    </div>

                    <div class="form-group">
                        <label for="symbol" class="form-control-label font-weight-bold">@lang('Symbol')</label>
                        <input type="text" class="form-control" id="symbol" maxlength="30" name="symbol" value="" placeholder="@lang('Symbol')" required>
                    </div>

                    <div class="form-group">
                        <label for="symbol" class="form-control-label font-weight-bold">@lang('Image')</label>
                        <div class="custom-file">
                          <input type="file" name="image" class="custom-file-input" id="customFileLangHTML">
                          <label class="custom-file-label" for="customFileLangHTML" data-browse="@lang('Choose Image')">@lang('Crypto Currency Image')</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Status') </label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                               data-toggle="toggle" data-on="Enable" data-off="Disable" name="status">
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

            $('.updateCurrency').on('click', function () {
                var modal = $('#updateModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=symbol]').val($(this).data('symbol'));
                var data = $(this).data('status');
                if(data == 1){
                    modal.find('input[name=status]').bootstrapToggle('on');
                }else{
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
                modal.modal('show');
            });
           
            $(document).on("change",".custom-file-input",function(){
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
    </script>
@endpush


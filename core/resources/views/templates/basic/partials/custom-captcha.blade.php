@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
    <div class="cmn--form--group form-group ">
         @php echo  getCustomCaptcha() @endphp
    </div>

    <div class="cmn--form--group form-group">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control cmn--form--control">
    </div>
@endif

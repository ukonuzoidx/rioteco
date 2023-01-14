@php
    $content = getContent('trend.content', true);
    $cryptoCurrency = App\Models\CryptoCurrencyPrice::latest()->get();
@endphp
<section class="trend-trade-section pt-120 pb-120">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-12 col-lg-8">
                <div class="section__header ">
                    <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
                    <p>
                        {{__(@$content->data_values->sub_heading)}}
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('1h%')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('7d%')</th>
                            <th>@lang('Market Cap')</th>
                            <th>@lang('24h%')</th>
                            <th>@lang('Volume(24h)')</th>
                            <th>@lang('Circulating Supply')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($cryptoCurrency as $crypto)
                                <tr>
                                    <td data-label="@lang('Name')">{{ @$crypto->name }} {{ @$crypto->symbol }}</td>
                                    <td data-label="@lang('1h%')">
                                        @if($crypto->one_hour < 0)
                                            <span class="badge badge--danger">{{ getAmount($crypto->one_hour,2) }} %</span>
                                        @else
                                            <span class="badge badge--success">{{ getAmount($crypto->one_hour,2) }} %</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Price')">{{getAmount($crypto->price,2)}} @lang("USD")</td>

                                    <td data-label="@lang('7d%')">
                                        @if($crypto->seven_day < 0)
                                            <span class="badge badge--danger">{{ getAmount($crypto->seven_day,2) }} %</span>
                                        @else
                                            <span class="badge badge--success">{{ getAmount($crypto->seven_day,2) }} %</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Market Cap')">$ {{ getAmount($crypto->market_cap, 2) }}</td>
                                    <td data-label="@lang('24h%')">
                                        @if($crypto->twenty_four < 0)
                                            <span class="badge badge--danger">{{ getAmount($crypto->twenty_four,2) }} %</span>
                                        @else
                                            <span class="badge badge--success">{{ getAmount($crypto->twenty_four,2) }} %</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Volume 24h')">$ {{getAmount($crypto->volume24h,2) }}</td>

                                    <td data-label="@lang('Circulating Supply')">{{ getAmount($crypto->circulating) }} {{ $crypto->symbol }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%"> @lang('No results found')!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>



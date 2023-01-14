<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameLog;
use App\Models\User;
use Carbon\Carbon;
use App\Models\PracticeLog;
use App\Models\Transaction;
use App\Models\GeneralSetting;
use App\Models\CryptoCurrencyPrice;
use Illuminate\Support\Arr;

class CronController extends Controller
{
    public function index()
    {
    	$gameLogs = GameLog::where('status', 0)->where('in_time', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach($gameLogs as $gameLog)
    	{
			$cryptoRate = getCoinRate($gameLog->crypto->symbol);
			$user = User::find($gameLog->user_id);
			if($gameLog->result == 0)
			{

				if($gameLog->hilow == 1)
				{
					if($gameLog->price_was < $cryptoRate)
					{
						$user->balance += $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
						$user->save();

                        $gameLogAmount = $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                        $details = 'Trade ' . $gameLog->crypto->name . ' ' . "WIN";
                        $this->transactions($user, $gameLogAmount, $details);
                        $gameLog->result = 1;
					}
					else if($gameLog->price_was > $cryptoRate) {
                        $gameLog->result = 2;
                    }else{
                    	$user->balance += $gameLog->amount;
						$user->save();

                        $gameLogAmount = $gameLog->amount;
                        $details = 'Trade ' . $gameLog->crypto->name . ' ' .  "Refund";
                        $this->transactions($user, $gameLogAmount, $details);
                        $gameLog->result = 3;
                    }
				}
                else if($gameLog->hilow == 2)
                {
                    if($gameLog->price_was > $cryptoRate)
                    {
                        $user->balance += $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                        $user->save();

                        $gameLogAmount = $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                        $details = 'Trade ' . $gameLog->crypto->name . ' ' . "WIN";
                        $this->transactions($user, $gameLogAmount, $details);
                        $gameLog->result = 1;
                    }
                    else if($gameLog->price_was < $cryptoRate)
                    {
                        $gameLog->result = 2;
                    }
                    else{
                        $user->balance += $gameLog->amount;
                        $user->save();

                        $gameLogAmount = $gameLog->amount;
                        $details = 'Trade ' . $gameLog->crypto->name . ' ' .  "Refund";
                        $this->transactions($user, $gameLogAmount, $details);
                        $gameLog->result = 3;
                    }
                }
                $gameLog->status = 1;
                $gameLog->save();
    		}
    	}
    }

    public function transactions($user, $gameLogAmount, $details)
    {
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $gameLogAmount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = "+";
        $transaction->details = $details;
        $transaction->trx = getTrx();
        $transaction->save();
    }

    public function store()
    {
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        $apiKey = $gnl->coin_api_key;
        $symbols = CryptoCurrencyPrice::get(['symbol']);

        if($symbols->isNotEmpty())
        {
            $symbolArray = $symbols->groupBy('symbol')->map(function ($item, $key) {
                return collect($item);
            });
            $symbol = Arr::flatten($symbolArray->keys());
            $crypto = implode(",", $symbol);

            $parameters = [
                'symbol' => $crypto
            ];
            $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
            $headers = [
              'Accepts: application/json',
              'X-CMC_PRO_API_KEY:'. $apiKey
            ];
            $qs = http_build_query($parameters);
            $request = "{$url}?{$qs}";

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $request,
              CURLOPT_HTTPHEADER => $headers,
              CURLOPT_RETURNTRANSFER => 1
            ));
            $responses = json_decode(curl_exec($curl));
            curl_close($curl);
            foreach ($responses->data as  $da) {
                $symbol = $da->symbol;
                $cryptoCurrencyPrice = CryptoCurrencyPrice::where('symbol', $da->symbol)->first();
                if ($cryptoCurrencyPrice) {
                    $cryptoCurrencyPrice->name = $da->name;
                    $cryptoCurrencyPrice->symbol = @$da->symbol;
                    $cryptoCurrencyPrice->one_hour = @$da->quote->USD->percent_change_1h;
                    $cryptoCurrencyPrice->price = @$da->quote->USD->price;
                    $cryptoCurrencyPrice->seven_day = @$da->quote->USD->percent_change_7d;
                    $cryptoCurrencyPrice->market_cap = @$da->quote->USD->market_cap;
                    $cryptoCurrencyPrice->twenty_four = @$da->quote->USD->percent_change_24h;
                    $cryptoCurrencyPrice->volume24h = @$da->quote->USD->volume_24h;
                    $cryptoCurrencyPrice->circulating = @$da->circulating_supply;
                    $cryptoCurrencyPrice->save();
                }
            }
        }
        else{
            $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
            $parameters = [
              'start' => '1',
              'limit' => '10',
              'convert' => 'USD'
            ];

            $headers = [
              'Accepts: application/json',
              'X-CMC_PRO_API_KEY:'. $apiKey
            ];

            $qs = http_build_query($parameters);
            $request = "{$url}?{$qs}";

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $request,
              CURLOPT_HTTPHEADER => $headers,
              CURLOPT_RETURNTRANSFER => 1
            ));

            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            foreach ($response->data as  $da) {
                $cryptoCurrencyPrice = new CryptoCurrencyPrice;
                $cryptoCurrencyPrice->name = $da->name;
                $cryptoCurrencyPrice->symbol = @$da->symbol;
                $cryptoCurrencyPrice->one_hour = @$da->quote->USD->percent_change_1h;
                $cryptoCurrencyPrice->price = @$da->quote->USD->price;
                $cryptoCurrencyPrice->seven_day = @$da->quote->USD->percent_change_7d;
                $cryptoCurrencyPrice->market_cap = @$da->quote->USD->market_cap;
                $cryptoCurrencyPrice->twenty_four = @$da->quote->USD->percent_change_24h;
                $cryptoCurrencyPrice->volume24h = @$da->quote->USD->volume_24h;
                $cryptoCurrencyPrice->circulating = @$da->circulating_supply;
                $cryptoCurrencyPrice->save();
            }
        }
    }

    public function practiceCron()
    {
        $practiceLogs = PracticeLog::where('status', 0)->where('in_time', '<', Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $gnl->last_cron_run =  Carbon::now();
        $gnl->save();

        foreach($practiceLogs as $practiceLog)
        {
            $cryptoRate = getCoinRate($practiceLog->crypto->symbol);
            $user = User::find($practiceLog->user_id);
            if($practiceLog->result == 0)
            {
                if($practiceLog->hilow == 1)
                {
                    if($practiceLog->price_was > $cryptoRate)
                    {
                        $user->demo_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                        $user->save();

                        $practiceLog->result = 1;
                    }
                    else if($practiceLog->price_was < $cryptoRate) {
                        $practiceLog->result = 2;
                    }else{
                        $user->demo_balance += $practiceLog->amount;
                        $user->save();

                        $practiceLog->result = 3;
                    }
                }
                else if($practiceLog->hilow == 2)
                {
                    if($practiceLog->price_was < $cryptoRate)
                    {
                        $user->demo_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                        $user->save();
                        $practiceLog->result = 1;
                    }
                    else if($practiceLog->price_was > $cryptoRate)
                    {
                        $practiceLog->result = 2;
                    }
                    else{
                        $user->demo_balance += $practiceLog->amount;
                        $user->save();
                        $practiceLog->result = 3;
                    }
                }
                $practiceLog->status = 1;
                $practiceLog->save();
            }
        }
    }
}

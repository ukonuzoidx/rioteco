<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoCurrency;
use App\Models\GeneralSetting;
use App\Models\GameSetting;
use App\Models\PracticeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DemoPlayGameController extends Controller
{

	public function btcRate(Request $request)
    {
	    $cryptoRate = getCoinRate($request->coinSymbol);
	    return $cryptoRate;
    }

	public function index()
	{
		$page_title = "Trade Now";
		$empty_message = "No Data Found";
		$cryptos = CryptoCurrency::where('status', 1)->get();
		return view(activeTemplate() . 'user.demoGame.game', compact('page_title', 'empty_message', 'cryptos'));
	}

    public function playGame($name)
    {
    	$currency = CryptoCurrency::where('name', $name)->firstOrFail();
        $gameSettings = GameSetting::latest()->get();
    	$page_title = "Trade With " . $currency->name;
    	return view(activeTemplate() . 'user.demoGame.play', compact('page_title', 'currency', 'gameSettings'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
            'coinId' => 'required|exists:crypto_currencies,id',
            'highlowType' => 'required|in:1,2',
            'duration' => 'required|exists:game_settings,time',
            'unit' => 'required|exists:game_settings,unit'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        }
        $crypto = CryptoCurrency::find($request->coinId);
        $user = Auth::user();
        $general = GeneralSetting::first();
        if($request->amount > $user->demo_balance){
            $response = [
                'value'         => 2,
                'message' => 'Your Practice Balance '.getAmount($user->demo_balance) . ' ' . $general->cur_text .' Not Enough! Please Add Practice Amoun',
            ];
            return response()->json($response);
        }
        $user->demo_balance -= $request->amount;
        $user->save();
        if ($request->highlow == 1) {
            $highlow = 'High';
        }else{
            $highlow = 'Low';
        }
        $practiceLog = new PracticeLog();
        $practiceLog->user_id = $user->id;
        $practiceLog->coin_id = $request->coinId;
        $practiceLog->amount = $request->amount;
        if($request->unit == "seconds")
        {
            $time = Carbon::now()->addSeconds($request->duration);
        }
        elseif($request->unit == "minutes")
        {
            $time = Carbon::now()->addMinutes($request->duration);
        }
        elseif($request->unit == "hours")
        {
            $time = Carbon::now()->addHours($request->duration);
        }
        $practiceLog->in_time = $time;
        $practiceLog->hilow = $request->highlowType;
        $practiceLog->price_was = getCoinRate($crypto->symbol);
        $practiceLog->save();
        $response = [
            'gameLogId' => $practiceLog->id,
            'value'     => 1,
            'trade'     => $practiceLog->price_was,
        ];
        return response()->json($response);
    }

    public function gameResult(Request $request)
    {
    	$validate = Validator::make($request->all(), [
            'gameLogId' => 'required|exists:practice_logs,id'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $user = Auth::user();
        $practiceLog = PracticeLog::where('id', $request->gameLogId)->where('user_id', $user->id)->firstOrFail();
        $gnl = GeneralSetting::first();
        $cryptoRate = getCoinRate($practiceLog->crypto->symbol);
        if($practiceLog->result == 0)
        {
            if($practiceLog->hilow == 1)
            {
                if($practiceLog->price_was < $cryptoRate)
                {
                    $user->demo_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $practiceLog->result = 1;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 1;
                }
                else if ($practiceLog->price_was > $cryptoRate) {
                    $practiceLog->result = 2;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 2;
                }else{
                    $user->demo_balance += $practiceLog->amount;
                    $user->save();

                    $practiceLog->result = 3;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 3;
                }
            }
            else if($practiceLog->hilow == 2)
            {
                if($practiceLog->price_was > $cryptoRate)
                {
                    $user->demo_balance += $practiceLog->amount + (($practiceLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $practiceLog->result = 1;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 1;
                }
                else if($practiceLog->price_was < $cryptoRate)
                {
                    $practiceLog->result = 2;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 2;
                }
                else{
                    $user->demo_balance += $practiceLog->amount;
                    $user->save();

                    $practiceLog->result = 3;
                    $practiceLog->status = 1;
                    $practiceLog->save();
                    return 3;
                }
            }
        }
    }

    public function practiceGameLog()
    {
        $user = Auth::user();
        $page_title = "Practice Trade History";
        $empty_message = "No Data Found";
        $practices = PracticeLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.demoGame.log', compact('page_title', 'empty_message', 'practices'));
    }


}

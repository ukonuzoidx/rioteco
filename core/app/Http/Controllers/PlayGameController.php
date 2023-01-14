<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoCurrency;
use App\Models\GameSetting;
use App\Models\GameLog;
use App\Models\Transaction;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PlayGameController extends Controller
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
		return view(activeTemplate() . 'user.game.game', compact('page_title', 'empty_message', 'cryptos'));
	}

    public function playGame($name)
    {
    	$empty_message = "No Data Found";
    	$currency = CryptoCurrency::where('name', $name)->firstOrFail();
        $gameSettings = GameSetting::latest()->get();
    	$page_title = "Trade With " . $currency->name;
    	return view(activeTemplate() . 'user.game.play', compact('page_title', 'empty_message', 'currency', 'gameSettings'));
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
        if($request->amount > $user->balance){
            $response = [
                'value'         => 2,
                'message' => 'Your Account Balance '.getAmount($user->balance) . ' ' . $general->cur_text .' Not Enough! Please Deposit Money',
            ];
            return response()->json($response);
        }
        $user->balance -= $request->amount;
        $user->save();
        if ($request->highlow == 1) {
            $highlow = 'High';
        }else{
            $highlow = 'Low';
        }
        $gameLog = new GameLog();
        $gameLog->user_id = $user->id;
        $gameLog->coin_id = $request->coinId;
        $gameLog->amount = $request->amount;
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
        $gameLog->in_time = $time;
        $gameLog->hilow = $request->highlowType;
        $gameLog->price_was = getCoinRate($crypto->symbol);
        $gameLog->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $gameLog->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = "-";
        $transaction->details = 'Trade ' . $crypto->name . ' ' . $highlow;
        $transaction->trx = getTrx();
        $transaction->save();
        $response = [
            'gameLogId' => $gameLog->id,
            'value'     => 1,
            'trade'     => $gameLog->price_was,
        ];
        return response()->json($response);
    }

    public function gameResult(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'gameLogId' => 'required|exists:game_logs,id'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        $user = Auth::user();
        $gnl = GeneralSetting::first();
        $gameLog = GameLog::where('id', $request->gameLogId)->where('user_id', $user->id)->firstOrFail();
        $cryptoRate = getCoinRate($gameLog->crypto->symbol);
        if($gameLog->result == 0)
        {
            if($gameLog->hilow == 1)
            {
                if($gameLog->price_was < $cryptoRate)
                {
                    $user->balance += $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $details = "Trade " . $gameLog->crypto->name . ' ' . "WIN";
                    $gameLogAmount = $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                    $this->transactions($user, $gameLogAmount, $details);

                    $gameLog->result = 1;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 1;
                }
                else if ($gameLog->price_was > $cryptoRate) {
                    $gameLog->result = 2;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 2;
                }else{
                    $user->balance += $gameLog->amount;
                    $user->save();

                    $details = "Trade " . $gameLog->crypto->name . ' ' .  "Refund";
                    $gameLogAmount = $gameLog->amount;
                    $this->transactions($user, $gameLogAmount, $details);

                    $gameLog->result = 3;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 3;
                }
            }
            else if($gameLog->hilow == 2)
            {
                if($gameLog->price_was > $cryptoRate)
                {
                    $user->balance += $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                    $user->save();

                    $details = "Trade " . $gameLog->crypto->name . ' ' . "WIN";
                    $gameLogAmount = $gameLog->amount + (($gameLog->amount / 100) * $gnl->profit);
                    $this->transactions($user, $gameLogAmount, $details);

                    $gameLog->result = 1;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 1;
                }
                else if($gameLog->price_was < $cryptoRate)
                {
                    $gameLog->result = 2;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 2;
                }
                else{
                    $user->balance += $gameLog->amount;
                    $user->save();

                    $details = "Trade " . $gameLog->crypto->name . ' ' .  "Refund";
                    $gameLogAmount = $gameLog->amount;
                    $this->transactions($user, $gameLogAmount, $details);
                    $gameLog->result = 3;
                    $gameLog->status = 1;
                    $gameLog->save();
                    return 3;
                }
            }
        }

    }

    public function gameLog()
    {
        $user = Auth::user();
        $page_title = "Trade History";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.game.log', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function winingGameLog()
    {
        $user = Auth::user();
        $page_title = "Wining Trade History";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('user_id', $user->id)->where('result', 1)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.game.log', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function losingGameLog()
    {
        $user = Auth::user();
        $page_title = "Losing Trade History";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('user_id', $user->id)->where('result', 2)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.game.log', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function drawGameLog()
    {
        $user = Auth::user();
        $page_title = "Draw Trade History";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('user_id', $user->id)->where('result', 3)->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.game.log', compact('page_title', 'empty_message', 'gamelogs'));
    }

    private function transactions($user, $gameLogAmount, $details)
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

}

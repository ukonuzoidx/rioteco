<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameSetting;

class GameSettingController extends Controller
{
    
    public function index()
    {
    	$page_title = "Trade Setting";
    	$empty_message = "No Data Found";
    	$games = GameSetting::latest()->paginate(getPaginate());
    	return view('admin.game.index', compact('games', 'empty_message', 'page_title'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'time' => 'required|integer',
    		'unit' => 'required'
    	]);
    	$gameSetting = new GameSetting();
    	$gameSetting->time = $request->time;
    	$gameSetting->unit = $request->unit;
        $gameSetting->save();
        $notify[] = ['success', 'Time Create Successfully'];
	    return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
    	$request->validate([
    		'id' => 'required|exists:game_settings,id',
    		'time' => 'required|integer',
    		'unit' => 'required|max:30'
    	]);
    	$gameSetting = GameSetting::find($request->id);
    	$gameSetting->time = $request->time;
    	$gameSetting->unit = $request->unit;
        $gameSetting->save();
        $notify[] = ['success', 'Time Update Successfully'];
	    return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
    	$request->validate(['id' => 'required|exists:game_settings,id']);
    	$crypto = GameSetting::find($request->id);
    	$crypto->delete();
    	$notify[] = ['success', 'Time Delete Successfully'];
	    return back()->withNotify($notify);
    }

}

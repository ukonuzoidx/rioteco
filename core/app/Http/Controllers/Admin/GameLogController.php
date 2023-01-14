<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameLog;

class GameLogController extends Controller
{

    public function index()
    {
    	$page_title = "Trade List";
    	$empty_message = "No Data Found";
    	$gamelogs = GameLog::latest()->paginate(getPaginate());
    	return view('admin.game_log.index', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function wining()
    {
        $page_title = "Wining Trade List";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('result', 1)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.game_log.index', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function losing()
    {
        $page_title = "Losing Trade List";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('result', 2)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.game_log.index', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function draw()
    {
        $page_title = "Draw Trade List";
        $empty_message = "No Data Found";
        $gamelogs = GameLog::where('result', 3)->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.game_log.index', compact('page_title', 'empty_message', 'gamelogs'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $gamelogs =  GameLog::whereHas('user',function($q) use ($search){
            $q->where('username', $search);
        }); 
        if($scope == 'wining') {
            $page_title .= 'Wining Trade Search';
            $gamelogs = $gamelogs->where('result', 1);
        }
        elseif($scope == 'losing') {
             $page_title .= 'Losing Trade Search';
            $gamelogs = $gamelogs->where('result', 2);
        }
        elseif($scope == 'draw') {
            $page_title .= 'Draw Trade Search';
            $gamelogs = $gamelogs->where('result', 3);
        }
        elseif($scope == 'list') {
            $page_title .= 'All Trade History Search';
        }
        $gamelogs = $gamelogs->paginate(getPaginate());
        $page_title .= ' - ' . $search;
        return view('admin.game_log.index', compact('page_title', 'empty_message', 'gamelogs', 'search'));
    }
}

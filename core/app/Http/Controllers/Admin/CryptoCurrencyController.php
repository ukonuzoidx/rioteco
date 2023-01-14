<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoCurrency;

class CryptoCurrencyController extends Controller
{
    
    public function index()
    {
    	$page_title = "Crypto Currency List";
    	$empty_message = "No Data Found";
    	$cryptos = CryptoCurrency::latest()->paginate(getPaginate());
    	return view('admin.crypto.index', compact('cryptos', 'page_title', 'empty_message'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required|max:80|unique:crypto_currencies',
    		'symbol' => 'required|unique:crypto_currencies|max:30',
    		'image' => 'required|mimes:jpeg,jpg,png'
    	]);
    	$crypto = new CryptoCurrency();
    	$crypto->name = $request->name;
    	$crypto->symbol = strtoupper($request->symbol);
    	$crypto->status = $request->status ? 1 : 0;
        $path = imagePath()['cryptoCurrency']['path'];
        $size = imagePath()['cryptoCurrency']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $crypto->image = $filename;
        $crypto->save();
        $notify[] = ['success', 'Crypto Currency Create Successfully'];
	    return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
    	$request->validate([
    		'id' => 'required|exists:crypto_currencies,id',
    		'name' => 'required|max:80|unique:crypto_currencies,name,' . $request->id,
    		'symbol' => 'required|max:30|unique:crypto_currencies,symbol,' . $request->id,
    		'image' => 'mimes:jpeg,jpg,png'
    	]);
    	$crypto = CryptoCurrency::find($request->id);
    	$crypto->name = $request->name;
    	$crypto->symbol = strtoupper($request->symbol);
    	$crypto->status = $request->status ? 1 : 0;
        $path = imagePath()['cryptoCurrency']['path'];
        $size = imagePath()['cryptoCurrency']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $crypto->image);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        	$crypto->image = $filename;
        }
        $crypto->save();
        $notify[] = ['success', 'Crypto Currency Update Successfully'];
	    return back()->withNotify($notify);
    }
}

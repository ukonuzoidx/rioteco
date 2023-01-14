<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeLog extends Model
{
    use HasFactory;

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function crypto()
    {
    	return $this->belongsTo(CryptoCurrency::class, 'coin_id');
    }
}

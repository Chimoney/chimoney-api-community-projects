<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal_request extends Model
{
    protected $guarded = [];

    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

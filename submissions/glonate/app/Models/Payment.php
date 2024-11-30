<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function reward(){
        return $this->belongsTo(Reward::class);
    }
    
    public function scopeSuccess($query){
        return $query->whereStatus('success');
    }
    public function scopePending($query){
        return $query->whereStatus('pending');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    public $timestamps = false;
    
    
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    
}

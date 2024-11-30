<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;
    
    public $guarded = [];

    protected $dates = ['end_date'];

    public function rewards(){
        return $this->hasMany(Reward::class);
    }

    public function updates(){
        return $this->hasMany(Update::class);
    }

    public function faqs(){
        return $this->hasMany(Faq::class);
    }

    public function days_left(){
        $diff = strtotime($this->end_date)-time();//time returns current time in seconds

        if ($diff > 0){
            return floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
        }
        return 0;
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function success_payments(){
        return $this->hasMany(Payment::class)->whereStatus('success');
    }
    
    public function total_raised(){
        $updateNow = true;

        if ($this->total_funded_last_upated_at){
            $nowDate = Carbon::now();
            $updatedAt = Carbon::createFromTimestamp(strtotime($this->total_funded_last_upated_at));

            //Calculate every in 12 hours
            if ($nowDate->diffInHours($updatedAt) < 12){
                $updateNow = false;
            }
        }

        if ($updateNow){
            $this->updateTotalNow();
        }

        return $this->total_funded;
    }

    public function updateTotalNow(){
        $nowDate = Carbon::now();
        $totalFunded = $this->success_payments()->sum('amount');
        $totalPaymentsCount = $this->success_payments()->count();

        $this->total_funded = $totalFunded;
        $this->total_payments = $totalPaymentsCount;
        $this->total_funded_last_upated_at = $nowDate->toDateTimeString();
        $this->save();
    }

    public function percent_raised(){
        $raised = $this->total_raised();
        $goal = $this->goal;

        $percent = 0;
        if ($raised > 0){
            $percent = round(($raised * 100) / $goal, 0, PHP_ROUND_HALF_DOWN);
        }
        return $percent;
    }

    public function amount_raised(){
        $raised = $this->total_raised();
        $user_commission_percent = $this->campaign_owner_commission;

        $user_commission = 0;
        $platform_owner_commission = 0;

        if ($raised > 0 && $user_commission_percent != null){
            $user_commission = ($raised * $user_commission_percent) / 100;
            $platform_owner_commission = $raised - $user_commission;
        }
        
        return (object) array(
            'amount_raised'                 => $raised,
            'campaign_owner_commission'     => $user_commission,
            'platform_owner_commission'     => $platform_owner_commission,
        );
    }

    /**
     * @return bool
     * Is has active campaign
     */
    public function is_ended(){
        if ($this->end_method == 'end_date'){
            if ($this->end_date < Carbon::today()->toDateString()){
                return true;
            }
        }elseif ($this->end_method == 'goal_achieve'){
            $raised = $this->total_raised();
            if ($this->goal <= $raised){
                return true;
            }
        }

        return false;
    }
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeBlocked($query){
        return $query->where('status', 2);
    }
    public function scopePending($query){
        return $query->where('status', 0);
    }
    public function scopeExpired($query){
        return $query->whereDate('end_date', '<', Carbon::today()->toDateString());
    }
    public function scopeFunded($query){
        return $query->where('is_funded', 1);
    }
    public function requested_withdrawal(){
        return $this->hasOne(Withdrawal_request::class);
    }

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function amount_prefilled(){
        $amount = $this->amount_prefilled;
        if ($amount){
            return explode(',', $amount);
        }
        return false;
    }
    
    public function feature_img_url($full_size = false){
        if ($this->feature_image){
            if ($full_size){
                return '/storage/uploads/campaigns/large/'.$this->feature_image;
            }
            return '/storage/uploads/campaigns/thumb/'.$this->feature_image;
        }else{
            return asset('/assets/images/campaign-placeholder.jpg');
        }
    }

}

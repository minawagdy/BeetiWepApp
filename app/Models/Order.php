<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Order extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "orders";

    protected $appends = array('is_paid',"required_paid_amount","delivery_distance_time_formatted","delivery_end_time_formatted","company_fees_percentage");

    protected $with = array('driver');

    public function promo() {
        return $this->belongsTo('App\Models\PromoCode',"promo_code");
    }

    public function driver() {
        return $this->belongsTo('App\Models\Driver',"driver_id");
    }

    public function orderProducts() {
        return $this->hasMany('App\Models\OrderProduct',"order_id");
    }
    public function orderReviews() {
//        return $this->hasMany('App\Models\OrderReviews',"order_id");
        return $this->hasMany(OrderReviews::class,'order_id');
    }

    public function status() {
        return $this->belongsTo('App\Models\OrderStatus',"status_id");
    }
    public function provider() {
        return $this->belongsTo('App\Models\Provider',"provider_id");
    }
    public function customer() {
        return $this->belongsTo(Customer::class,'client_id');
    }

    public function bankTransfer() {
        return $this->belongsTo("\App\Models\BankTransferRequest",'bank_requrest_id');
    }
    public function payment() {
        return $this->belongsTo(PaymentMethod::class,"payment_method");
    }
      public function address() {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function getClientExtraPaidAmountAttribute() {
        if($this->client_paid_amount){
            if($this->client_paid_amount > $this->required_paid_amount){
                return $this->client_paid_amount-$this->required_paid_amount;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getIsPaidAttribute() {
        $isPaid = false;
        if($this->payment_method != 57){
            $isPaid = true;
        }else{
            if($this->wallet_amount == ($this->delivery_fees + $this->total_amount)){
                $isPaid = true;
            }else{
                $isPaid = false;
            }

        }

		return 	$isPaid;
	}

    public function getRequiredPaidAmountAttribute() {
        $amount = 0;
        if($this->payment_method != 57){
            $amount = 0;
        }else{
            if($this->wallet_amount == ($this->delivery_fees + $this->total_amount)){
                $amount = 0;
            }else{
               $amount = ($this->delivery_fees + $this->total_amount) - $this->wallet_amount;
            }

        }
        return 	$amount;
    }

     public function getPickupTimeAttribute($date) {
        if ($date != null) {
            return Carbon::parse($date)->format('F j, Y @ g:i A');
        }
        else{
            return $date;
        }
     }

     public function getDeliveryTimeAttribute($date) {
         if ($date != null) {
             return Carbon::parse($date)->format('F j, Y @ g:i A');
         }
         else{
             return $date;
         }

     }

    public function getDeliveryDistanceTimeFormattedAttribute($date) {
       return  gmdate("H:i:s",  $this->delivery_distance_time);
    }
     public function getDeliveryEndTimeFormattedAttribute($date) {
        $x = $this->delivery_distance_time;
         return Carbon::parse($this->delivery_start_time)->addSecond($x)->format('F j, Y  g:i A');
     }
     public function getCompanyFeesPercentageAttribute($data)
     {
         if ($this->company_fees == 0)
         {
             return $data = 0;
         }
         else {
             $data = $this->company_fees;
             return $data;
         }
     }
    //  public  function getDeliveryFeesPercentageAttribute($data)
    //  {
    //      if ($this->required_paid_amount == 0)
    //      {
    //          return $data = 0;
    //      }
    //      else {
    //          $data = ($this->delivery_fees / $this->required_paid_amount) * 100;
    //          return $data;
    //      }
    //  }
}

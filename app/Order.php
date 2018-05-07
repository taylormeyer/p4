<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function getFormatedOrderIdAttribute($value)
    {
        $data = "";
        if(!empty($value)) {
            $data = "ODR-".str_pad($value, 3, '0', STR_PAD_LEFT);
        }
        return $data;      
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem', "order_id", "id");
    }

    public function orderUser()
    {
        return $this->hasOne('App\UserOrder', "order_id", "id");
    }
}

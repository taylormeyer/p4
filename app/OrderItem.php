<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'item_order';
    protected $guarded = ['id'];

    public function menuItem()
    {
        return $this->hasOne('App\MenuItem', "id", "menu_item_id");
    }
}

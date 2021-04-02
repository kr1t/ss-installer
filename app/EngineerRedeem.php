<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineerRedeem extends Model
{
    protected $table = 'engineer_redeems';
    protected $fillable = [
        'engineer_id',
        'name',
        'address',
        'tel',
        'redeem_item_id'
    ];

    public function engineerInfo(){
        return $this->hasOne('App\Engineer', 'id', 'engineer_id');
    }

    public function redeemItem(){
        return $this->hasOne('App\RedeemItem', 'id', 'redeem_item_id');
    }
}

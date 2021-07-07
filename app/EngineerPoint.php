<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineerPoint extends Model
{
    protected $table = 'engineer_points';
    protected $fillable = [
        'engineer_id',
        'point',
        'redeem_item_id',
        'engineer_redeem_id',
        'created_at',
//        'updated_at',
    ];

    protected $appends = ['redeem_item'];

    public function getRedeemItemAttribute()
    {
        $redeemItem = RedeemItem::find($this->attributes['redeem_item_id']);
        return $redeemItem;
    }

    public function engineerRedeem()
    {
        return $this->hasOne('App\RedeemItem', 'id', 'redeem_item_id');
    }
}

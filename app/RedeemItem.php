<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemItem extends Model
{
    protected $table = 'redeem_items';
    protected $fillable = [
        'name',
        'value',
        'redeem_point'
    ];

}

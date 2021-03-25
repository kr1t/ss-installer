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
}

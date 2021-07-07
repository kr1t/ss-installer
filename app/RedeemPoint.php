<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemPoint extends Model
{
    protected $table = 'redeem_points';
    protected $fillable = [
        'job_id',
        'jobs_create_date',
        'jobs_update_date',
        'point',
        'engineer_id'
    ];
}

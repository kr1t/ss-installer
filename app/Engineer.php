<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $fillable = ['first_name_th', 'last_name_th', 'first_name_en', 'last_name_en', 'email', 'tel', 'type_of_work', 'shop', 'province', 'history_install', 'month', 'line_uid'];
}

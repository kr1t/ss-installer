<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PA\ProvinceTh\Factory;

class Engineer extends Model
{
    protected $fillable = ['first_name_th', 'last_name_th', 'first_name_en', 'last_name_en', 'email', 'tel', 'type_of_work', 'shop', 'province', 'history_install', 'month', 'line_uid'];

    public function getProvinceAttribute($q)
    {
        $provinces = Factory::province();
        $province = $provinces->find($q);
        return $province['name_th'];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PA\ProvinceTh\Factory;

class Engineer extends Model
{
    protected $fillable = ['first_name_th', 'last_name_th', 'first_name_en', 'last_name_en', 'email', 'tel', 'type_of_work', 'shop', 'province', 'history_install', 'month', 'line_uid', 'installer_id', 'point'];

    public function getProvinceAttribute($q)
    {
        $provinces = Factory::province();
        $province = $provinces->find($q);
        return $province['name_th'];
    }

    public function getTypeOfWorkAttribute($type)
    {
        $typeName  = '';
        switch ($type) {
            case 1:
                $typeName = 'ติดตั้ง';
                break;
            case 2:
                $typeName = 'ซ่อม';
                break;
            case 3:
                $typeName = 'ติดตั้ง + ซ่อม';
                break;
        }
        return
            $typeName;
    }
}

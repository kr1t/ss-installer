<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PA\ProvinceTh\Factory;

class Engineer extends Model
{
    protected $table = 'engineers';
    protected $fillable = [
        'first_name_th',
        'last_name_th',
        'first_name_en',
        'last_name_en',
        'email',
        'tel',
        'type_of_work',
        'shop',
        'province',
        'history_install',
        'month',
        'line_uid',
        'installer_id',
        'point',
        'notification_count',
    ];

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

    protected $appends = ['total', 'lastest_redeem_address'];

    public function getTotalAttribute()
    {
        $points = $this->points();
        return $points->sum('point');
    }

    public function getLastestRedeemAddressAttribute()
    {
        try {
            $lastest = EngineerRedeem::select('address')
                ->where('engineer_id', $this->attributes['id'])
                ->latest()
                ->first();
            $address = $lastest->address;
            return $address;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function points()
    {
        return $this->hasMany('App\EngineerPoint');
    }
}

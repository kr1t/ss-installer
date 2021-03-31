<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EngineerAnswer extends Model
{
    protected $table = 'engineer_answers';
    protected $fillable = [
        'engineer_id',
        'exam_type',
        'score',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'answer_5',
        'answer_6',
        'answer_7',
        'answer_8',
        'answer_9',
        'answer_10',
        'answer_11',
        'answer_12',
        'answer_13',
        'answer_14',
        'answer_15',
        'answer_16',
        'answer_17',
        'answer_18',
        'answer_19',
        'answer_19',
        'answer_20',
    ];

    public function engineerInfo(){
        return $this->hasOne('App\Engineer', 'id', 'engineer_id');
    }
}

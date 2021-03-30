<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamPermission extends Model
{
    protected $table = 'exam_permissions';
    protected $fillable = [
        'engineer_id',
        'level',
        'status',
        'created_at',
        'updated_at',
    ];


}

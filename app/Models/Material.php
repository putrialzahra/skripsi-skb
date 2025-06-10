<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'class_room_id',
        'subject_id',
        'teacher_id',
    ];
}

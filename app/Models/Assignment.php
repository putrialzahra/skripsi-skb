<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'due_date',
        'class_room_id',
        'subject_id',
        'teacher_id',
    ];

}

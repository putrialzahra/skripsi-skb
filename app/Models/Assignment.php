<?php

namespace App\Models;

use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\User;
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

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function classRooms()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id', 'id');
    }   


}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'class_room_id',
        'subject_id',
    ];
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

        
}

<?php

namespace App\Models;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class ClassStudent extends Model
{
    protected $fillable = [
        'class_room_id',
        'student_id',
    ];

    /**
     * Get the class room that owns the class student.
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * Get the student that owns the class student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'class_teachers', 'class_room_id', 'teacher_id');
    }
    
}

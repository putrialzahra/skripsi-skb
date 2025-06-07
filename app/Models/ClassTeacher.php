<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    protected $fillable = [
        'class_room_id',
        'teacher_id',
    ];

      // Relasi ke ClassRoom
      public function classRoom()
      {
          return $this->belongsTo(\App\Models\ClassRoom::class);
      }
  
      // Relasi ke User sebagai Teacher
      public function teacher()
      {
          return $this->belongsTo(\App\Models\User::class, 'teacher_id');
      }
  }



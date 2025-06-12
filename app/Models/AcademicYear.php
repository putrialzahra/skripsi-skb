<?php

namespace App\Models;
use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    //
    protected $fillable = [
        'name',
        'is_active',
    ];
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
}

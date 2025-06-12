<?php

namespace App\Models;
use App\Models\AcademicYear;
use App\Models\Package;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    protected $fillable = [
        'name',
        'academic_year_id',
        'package_id'
    ];

    /**
     * Get the academic year that owns the class room.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the package that owns the class room.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the attendances for the class room.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_room_id');
    }
}

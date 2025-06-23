<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'class_room_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'string',
    ];

    public const STATUS_HADIR = 'hadir';
    public const STATUS_SAKIT = 'sakit';
    public const STATUS_IZIN = 'izin';
    public const STATUS_ALPA = 'alpa';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_ALPA => 'Alpa',
        ];
    }

    // Tambahkan relasi ke Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ke ClassRoom (perhatikan penulisan camelCase)
    public function classStudent()
    {
        return $this->belongsToMany(ClassStudent::class, 'class_students', 'attendance_id', 'student_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(\App\Models\ClassRoom::class);
    }

}
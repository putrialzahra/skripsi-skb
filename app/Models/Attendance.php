<?php

namespace App\Models;

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
        return $this->belongsTo(Student::class);
    }

    // Tambahkan relasi ke ClassRoom (perhatikan penulisan camelCase)
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id'); // Khusus ini perlu specify column karena nama kolom tidak standar
    }
}
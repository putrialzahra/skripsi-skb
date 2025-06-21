<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'file',
        'score',
    
    ];
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function student()
{
    return $this->belongsTo(User::class, 'student_id'); // ← benar jika siswa ada di tabel users
}
}

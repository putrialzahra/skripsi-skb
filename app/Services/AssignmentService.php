<?php
namespace App\Services;


use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;

class AssignmentService
{
    /**
     * Ambil semua assignment untuk kelas tertentu.
     */
    public function getAssignmentsForClass(int $classRoomId): array
    {
        return Assignment::where('class_room_id', $classRoomId)
            ->with('teacher')
            ->get()
            ->map(function ($assignment) {
                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'description' => $assignment->description,
                    'due_date' => $assignment->due_date,
                    'file' => $assignment->file,
                    'teacher_name' => optional($assignment->teacher)->name ?? 'N/A',
                ];
            })
            ->toArray();
    }

    /**
     * Ambil assignment beserta status submit dari siswa.
     */
    public function getAssignmentsWithStatus(int $classRoomId, ?int $studentId = null): array
    {
        if (!$studentId) {
            $studentId = Auth::id();
        }

        $assignments = Assignment::where('class_room_id', $classRoomId)
            ->with(['submissions' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->get();

        return $assignments->map(function ($assignment) use ($studentId) {
            $submission = $assignment->submissions->first();

            return [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'description' => $assignment->description,
                'due_date' => $assignment->due_date,
                'file' => $assignment->file,
                'teacher_name' => optional($assignment->teacher)->name ?? 'N/A',
                'submitted' => (bool) $submission,
                'submission_id' => optional($submission)->id,
                'submitted_at' => optional($submission)->created_at,
            ];
        })->toArray();
    }
}
<?php
namespace App\Services;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Collection;

class AssignmentService
{
    /**
     * Get students for a class with their assignment submission status (if already submitted).
     */
    public function getStudentListWithSubmissionStatus(int $classRoomId, int $assignmentId): array
    {
        $classRoom = ClassRoom::with('students')->findOrFail($classRoomId);
        $assignment = Assignment::findOrFail($assignmentId);

        $submissions = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->get()
            ->keyBy('student_id');

        return $classRoom->students->map(function (User $student) use ($submissions, $assignment) {
            $submission = $submissions[$student->id] ?? null;
            
            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'submission_file' => $submission->file_path ?? null,
                'status' => $this->determineStatus($submission, $assignment),
                'score' => $submission->score ?? null,
            ];
        })->toArray();
    }

    /**
     * Determine submission status based on due date and submission time
     */
    protected function determineStatus(?AssignmentSubmission $submission, Assignment $assignment): string
    {
        if (!$submission) {
            return 'missing';
        }

        if ($submission->submitted_at->gt($assignment->due_date)) {
            return 'late';
        }

        return 'submitted';
    }
}
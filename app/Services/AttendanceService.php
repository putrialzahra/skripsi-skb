<?php
namespace App\Services;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Attendance;
use Illuminate\Support\Collection;

class AttendanceService
{
    /**
     * Get students for a class with their attendance status (if already recorded).
     */
    public function getStudentListWithStatuses(int $classRoomId, string $date): array
    {
        $classRoom = ClassRoom::with('students')->findOrFail($classRoomId);

        $attendances = Attendance::where('class_room_id', $classRoomId)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return $classRoom->students->map(function (User $student) use ($attendances) {
            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'status' => $attendances[$student->id]->status ?? null,
            ];
        })->toArray();
    }
}
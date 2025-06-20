<?php

namespace App\Filament\Pages;

use App\Models\Assignment;
use App\Models\ClassRoom;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use App\Models\User;
use App\Services\AssignmentService;

class TakeAssignment extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.take-assignment';

    public $class_room_id;
    public $assignments = [];

    public function updatedClassRoomId(): void
    {
        if ($this->class_room_id) {
            // Ambil semua assignment untuk kelas ini
            $this->assignments = Assignment::where('class_room_id', $this->class_room_id)
                ->with('teacher') // Jika ingin tampilkan nama guru
                ->get()
                ->map(function ($assignment) {
                    return [
                        'title' => $assignment->title,
                        'description' => $assignment->description,
                        'due_date' => $assignment->due_date,
                        'teacher_name' => optional($assignment->teacher)->name ?? 'N/A',
                    ];
                })
                ->toArray();
        }
    }

    protected function getFormSchema(): array
    {
        return [
                Select::make('class_room_id')
                ->label('Pilih Kelas')
                ->options(function () {
                    return ClassRoom::whereHas('students', function ($query) {
                        $query->where('student_id', auth()->user()->id); // ✅ Benar
                    })->pluck('name', 'id');
                })
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($set) => $set('assignments', [])),

            Repeater::make('assignments')
                ->schema([
                    TextInput::make('title')->disabled(),
                    TextInput::make('description')->disabled(),
                    TextInput::make('due_date')->disabled()->label('Tanggal Deadline'),
                    TextInput::make('teacher_name')->disabled()->label('Guru'),
                ])
                ->visible(fn (callable $get) => count($get('assignments')) > 0)
                ->default(fn () => $this->assignments),
        ];
    }
}
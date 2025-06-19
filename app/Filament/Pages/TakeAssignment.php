<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Models\ClassRoom;
use App\Models\Assignment;
use Filament\Forms\Concerns\InteractsWithForms;

class TakeAssignment extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.take-assignment';

    public $class_room_id;
    public $assignment_id;
    public $students = [];

    public function updated($property): void
    {
        if (in_array($property, ['class_room_id', 'assignment_id']) && $this->class_room_id && $this->assignment_id) {
            $this->students = app(\App\Services\AssignmentService::class)
                ->getStudentListWithSubmissionStatus($this->class_room_id, $this->assignment_id);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('class_room_id')
                ->label('Class')
                ->options(
                    fn () => auth()->user()
                        ->classRoomsTeaching()
                        ->select('class_rooms.id', 'class_rooms.name')
                        ->pluck('name', 'id')
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('students', [])),

            Select::make('assignment_id')
                ->label('Assignment')
                ->options(
                    fn (callable $get) => Assignment::where('class_room_id', $get('class_room_id'))
                        ->select('id', 'title')
                        ->pluck('title', 'id')
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('students', [])),

            Repeater::make('students')
                ->label('Student Submissions')
                ->schema([
                    Hidden::make('student_id'),
                    TextInput::make('student_name')->disabled(),
                    FileUpload::make('submission_file')
                        ->label('File Submission')
                        ->directory('assignment-submissions')
                        ->preserveFilenames()
                        ->downloadable(),
                    Select::make('status')
                        ->live()
                        ->options([
                            'submitted' => 'Submitted',
                            'late' => 'Late',
                            'missing' => 'Missing',
                        ])
                        ->default('missing')
                        ->required(),
                    TextInput::make('score')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100),
                ])
                ->visible(fn (callable $get) => $get('class_room_id') && $get('assignment_id'))
                ->default(fn (callable $get) => app(\App\Services\AssignmentService::class)->getStudentListWithSubmissionStatus(
                    $get('class_room_id'),
                    $get('assignment_id')
                )),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data['students'] as $entry) {
            \App\Models\AssignmentSubmission::updateOrCreate(
                [
                    'student_id' => $entry['student_id'],
                    'assignment_id' => $this->assignment_id,
                ],
                [
                    'file_path' => $entry['submission_file'] ?? null,
                    'status' => $entry['status'],
                    'score' => $entry['score'] ?? null,
                    'submitted_at' => now(),
                ]
            );
        }

        \Filament\Notifications\Notification::make()
            ->title('Assignment submissions recorded successfully')
            ->success()
            ->send();
    }
}
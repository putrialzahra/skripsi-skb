<?php

namespace App\Filament\Pages;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassRoom;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class LihatAssignment extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string $view = 'filament.pages.lihat-assignment';
    protected static ?string $navigationLabel = 'Lihat Assignment';

    public $class_room_id;
    public $assignment_id;
    public $submissions = [];

    public function updatedClassRoomId(): void
    {
        $this->assignment_id = null;
        $this->submissions = [];
    }

    public function updatedAssignmentId(): void
    {
        if ($this->assignment_id) {
            $this->loadSubmissions();
        }
    }

    protected function loadSubmissions(): void
    {
        $this->submissions = AssignmentSubmission::with(['student', 'assignment'])
            ->where('assignment_id', $this->assignment_id)
            ->get()
            ->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'student_name' => $submission->student->name,
                    'file' => $submission->file,
                    'score' => $submission->score,
                    'submitted_at' => $submission->created_at->format('Y-m-d H:i'),
                ];
            })
            ->toArray();
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Filter Assignment')
                ->schema([
                    Select::make('class_room_id')
                        ->label('Class')
                        ->options(
                            fn () => Auth::user()
                                ->classRoomsTeaching()
                                ->select('class_rooms.id', 'class_rooms.name')
                                ->pluck('class_rooms.name', 'class_rooms.id')
                        )
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($set) => $set('assignment_id', null)),

                    Select::make('assignment_id')
                        ->label('Assignment')
                        ->options(function (callable $get) {
                            if (!$get('class_room_id')) {
                                return [];
                            }
                            return Assignment::where('class_room_id', $get('class_room_id'))
                                ->select('assignments.id', 'assignments.title')
                                ->pluck('title', 'id');
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn () => $this->loadSubmissions()),
                ])
                ->columns(2),

                Repeater::make('submissions')
                ->label('Daftar Submission Siswa')
                ->schema([
                    Hidden::make('id'),
                    TextInput::make('student_name')->disabled(),
                    TextInput::make('file')
                        ->label('File')
                        ->disabled(),   
                    TextInput::make('score')
                        ->label('Nilai')
                        ->numeric(),
                ])
                ->visible(fn (callable $get) => $get('class_room_id') && $get('assignment_id'))
                ->default(fn () => is_array($this->submissions) ? $this->submissions : [])
            
                
        ];
    }

    public function saveScores(): void
    {
        $data = $this->form->getState();

        foreach ($data['submissions'] as $submission) {
            AssignmentSubmission::where('id', $submission['id'])
                ->update(['score' => $submission['score']]);
        }

        Notification::make()
            ->title('Nilai berhasil disimpan')
            ->success()
            ->send();
    }

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('teacher');
    }
}
<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;

class TakeAttendance extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static string $view = 'filament.pages.take-attendance';

    public $class_room_id;
    public $date;
    public $students = [];

    public function updated($property): void
    {
        if (in_array($property, ['class_room_id', 'date']) && $this->class_room_id && $this->date) {
            $this->students = app(\App\Services\AttendanceService::class)
                ->getStudentListWithStatuses($this->class_room_id, $this->date);
        }
    }

    // Kita buat dulu form nya
    protected function getFormSchema(): array
    {
        return [
            Select::make('class_room_id')
                ->label('Class')
                ->options(
                    fn () => auth()->user()
                        ->classRoomsTeaching() // A custom relationship to get assigned classes
                        ->select('class_rooms.id', 'class_rooms.name')
                        ->pluck('name', 'id')
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('students', [])),

            DatePicker::make('date')
                ->required()
                ->reactive(),

            Repeater::make('students')
                ->label('Student Attendance')
                ->schema([
                    Hidden::make('student_id'),
                    TextInput::make('student_name')->disabled(),
                    Select::make('status')
                        ->live()
                        ->options([
                            'hadir' => 'Hadir',
                            'sakit' => 'Sakit',
                            'izin' => 'izin',
                            'alpa' => 'Alpa',
                        ])
                        ->default('hadir')
                        ->required(),
                ])
                ->visible(fn (callable $get) => $get('class_room_id') && $get('date'))
                ->default(fn (callable $get) => app(\App\Services\AttendanceService::class)->getStudentListWithStatuses(
                    $get('class_room_id'),
                    $get('date')
                )),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        foreach ($data['students'] as $entry) {
            \App\Models\Attendance::updateOrCreate(
                [
                    'student_id' => $entry['student_id'],
                    'class_room_id' => $this->class_room_id,
                    'date' => $this->date,
                ],
                [
                    'status' => $entry['status'],
                ]
            );
        }

        \Filament\Notifications\Notification::make()
            ->title('Attendance recorded successfully')
            ->success()
            ->send();
    }


}

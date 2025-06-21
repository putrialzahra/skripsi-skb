<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\ClassStudent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_student_id')
                ->label('Siswa')
                ->options(
                    fn () => ClassStudent::all()->pluck('name', 'id')
                )
                ->required(),
                Forms\Components\Select::make('class_room_id')
                ->label('Kelas')
                ->options(
                    fn () => ClassRoom::all()->pluck('name', 'id')
                )
                ->required(),
                DatePicker::make('date')
                    ->required(),
                Select::make('status')
                    ->options(Attendance::getStatuses())
                    ->default(Attendance::STATUS_HADIR)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('class_student_id')
            ->getStateUsing(fn ($record) => $record->classStudent?->name)
                ->label('Siswa')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('class_room_id')
            ->getStateUsing(fn ($record) => $record->classRoom?->name)
                ->label('Kelas')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->searchable()
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    Attendance::STATUS_HADIR => 'success',
                    Attendance::STATUS_SAKIT => 'warning',
                    Attendance::STATUS_IZIN => 'info',
                    Attendance::STATUS_ALPA => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => Attendance::getStatuses()[$state] ?? $state),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options(Attendance::getStatuses()),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('student');
    }
}

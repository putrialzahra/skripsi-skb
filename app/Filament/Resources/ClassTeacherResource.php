<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassTeacherResource\Pages;
use App\Filament\Resources\ClassTeacherResource\RelationManagers;
use App\Models\ClassTeacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\ClassRoom;

class ClassTeacherResource extends Resource
{
    protected static ?string $model = ClassTeacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_room_id')
                    ->label('Kelas')
                    ->options(
                        fn () => ClassRoom::all()->pluck('name', 'id')
                    )
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Guru')
                    ->options(
                        User::whereHas('roles', function ($query) {
                                $query->where('name', 'teacher');
                            })
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('class_room_id')
                    ->getStateUsing(fn ($record) => $record->classRoom?->name)
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher_id')
                    ->getStateUsing(fn ($record) => $record->teacher?->name)
                    ->label('Guru')
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('class_room_id')
                    ->label('Kelas')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->label('Guru')
                    ->searchable(),
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
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassTeachers::route('/'),
            'create' => Pages\CreateClassTeacher::route('/create'),
            'edit' => Pages\EditClassTeacher::route('/{record}/edit'),
        ];
    }
}

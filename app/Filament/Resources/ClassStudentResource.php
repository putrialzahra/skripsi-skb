<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassStudentResource\Pages;
use App\Filament\Resources\ClassStudentResource\RelationManagers;
use App\Models\ClassStudent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class ClassStudentResource extends Resource
{
    protected static ?string $model = ClassStudent::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_room_id')
                    ->label('Kelas')
                    ->options(
                        fn () => \App\Models\ClassRoom::all()->pluck('name', 'id')
                    )
                    ->required(),
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->options(
                        User::whereHas('roles', function ($query) {
                                $query->where('name', 'student');
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
                Tables\Columns\TextColumn::make('student_id')
                    ->getStateUsing(fn ($record) => $record->student?->name)
                    ->label('Siswa')
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
                Tables\Filters\SelectFilter::make('student_id')
                    ->label('Siswa')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassStudents::route('/'),
            'create' => Pages\CreateClassStudent::route('/create'),
            'edit' => Pages\EditClassStudent::route('/{record}/edit'),
        ];
    }


}

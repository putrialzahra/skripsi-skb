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
use Illuminate\Support\Facades\Auth;
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
                    ->relationship('classRoom', 'name')
                    ->required(),
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'name')
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
                Tables\Columns\TextColumn::make('classRoom.name')
                    ->label('Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Siswa')
                    ->searchable(),
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
                    ->relationship('classRoom', 'name'),
                Tables\Filters\SelectFilter::make('student_id')
                    ->relationship('student', 'name'),
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

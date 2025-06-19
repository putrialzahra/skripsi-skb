<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassRoomResource\Pages;
use App\Filament\Resources\ClassRoomResource\RelationManagers;
use App\Models\ClassRoom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassRoomResource extends Resource
{
    protected static ?string $model = ClassRoom::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->options(
                        fn () => \App\Models\AcademicYear::all()->pluck('name', 'id')
                    )
                    ->required(),
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->options(
                        fn () => \App\Models\Package::all()->pluck('name', 'id')
                    )
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->getStateUsing(fn ($record) => $record->academicYear?->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('package_id')
                    ->label('Package')
                    ->getStateUsing(fn ($record) => $record->package?->name)
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('package_id')
                    ->label('Package')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
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
            'index' => Pages\ListClassRooms::route('/'),
            'create' => Pages\CreateClassRoom::route('/create'),
            'edit' => Pages\EditClassRoom::route('/{record}/edit'),
        ];
    }
}

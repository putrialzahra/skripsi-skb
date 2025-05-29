<?php

namespace App\Filament\Resources\ClassStudentResource\Pages;

use App\Filament\Resources\ClassStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassStudent extends EditRecord
{
    protected static string $resource = ClassStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\DepartureDateResource\Pages;

use App\Filament\Resources\DepartureDateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartureDate extends EditRecord
{
    protected static string $resource = DepartureDateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

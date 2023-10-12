<?php

namespace App\Filament\Resources\DepartureDateResource\Pages;

use App\Filament\Resources\DepartureDateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartureDates extends ListRecords
{
    protected static string $resource = DepartureDateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

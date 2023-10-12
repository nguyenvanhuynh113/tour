<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Overview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            //
            Card::make('Test', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-down')
                ->chart([7, 1, 14, 3, 19, 4, 17])
                ->color('danger'),
            Card::make('Test', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 10, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Test', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Test', '192.1k')
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}

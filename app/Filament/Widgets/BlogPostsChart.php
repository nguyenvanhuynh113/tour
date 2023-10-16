<?php

namespace App\Filament\Widgets;

use App\Models\Tour;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BlogPostsChart extends BarChartWidget
{
    protected static ?string $heading = 'Chuyến đi';

    protected function getData(): array
    {
        $data = Trend::model(Tour::class)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Số lượng chuyến đi',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#FF0000',
                    'borderColor' => '#FF0000',
                    'fill' => false
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => 'Ngày ' . date('d', strtotime($value->date))),
        ];
    }
}

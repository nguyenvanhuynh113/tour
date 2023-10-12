<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OderChart extends BarChartWidget
{
    protected static ?string $heading = 'Đơn hàng';

    protected function getData(): array
    {
        $data = Trend::model(Blog::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng đơn hàng',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#98FB98',
                    'borderColor' => '#98FB98',
                    'fill' => false
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }
}

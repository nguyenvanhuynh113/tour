<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OderChart extends LineChartWidget
{
    protected static ?string $heading = 'Đơn hàng';

    protected function getData(): array
    {
        $data = Trend::model(Booking::class)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng đơn hàng',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#11d62e',
                    'borderColor' => '#11d62e',
                    'fill' => false
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => 'Ngày ' . date('d', strtotime($value->date))),
        ];
    }
}

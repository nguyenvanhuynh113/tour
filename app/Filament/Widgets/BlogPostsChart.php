<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BlogPostsChart extends LineChartWidget
{
    protected static ?string $heading = 'Bài viết';

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
                    'label' => 'Số lượng bài viết',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '	#FF0000',
                    'borderColor' => '#FF0000',
                    'fill'=>false
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}

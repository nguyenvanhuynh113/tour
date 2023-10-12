<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Bài viết gần đây';

    protected function getTableQuery(): Builder
    {
        return Blog::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('Mã')->sortable(),
            Tables\Columns\TextColumn::make('title')
                ->limit('30')
                ->label('Tiêu đề')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('user.name')->label('Người tạo')
                ->searchable(),
            Tables\Columns\ImageColumn::make('image')->circular(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('Y-m-d')
                ->label('Ngày tạo'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }
}

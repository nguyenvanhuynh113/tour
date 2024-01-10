<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Đơn hàng mới';

    protected function getTableQuery(): Builder
    {
        return Booking::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('booking_number')->label('Mã HĐ')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('customer_name')->searchable()->sortable()->label('Khách hàng'),
            Tables\Columns\TextColumn::make('person')->sortable()->label('Số lượng vé'),
            Tables\Columns\TextColumn::make('total_prices')
                ->money('vnd')
                ->label('Tổng')->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('Y-m-d')->sortable()
                ->label('Ngày đặt'),
            BadgeColumn::make('status')
                ->colors([
                    'success' => 'thanh toán thành công',
                    'danger' => 'chưa thanh toán',
                    'warning' => 'đăng ký giữ chỗ',
                ])
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

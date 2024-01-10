<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';
    protected static ?string $navigationGroup = 'Quản lý Tour';
    protected static ?string $label = 'Mã Giảm Giá';

    protected static ?string $slug = 'ma-giam-gia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('coupon_code')
                        ->default('GIAMGIA-' . rand(99999, 10000000))
                        ->required()
                        ->label('Mã Giảm Giá')
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('coupon_start_date')
                        ->label('Ngày bắt đầu')
                        ->minDate(Carbon::yesterday())
                        ->required(),
                    Forms\Components\DateTimePicker::make('coupon_end_date')
                        ->label('Ngày kết thúc')
                        ->required(),
                    Forms\Components\TextInput::make('discount_value')
                        ->label('Giá trị giảm')
                        ->prefix('%')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required(),
                    Forms\Components\TextInput::make('max_discount_prices')
                        ->label('Giảm tối đa')
                        ->mask(fn(Mask $mask) => $mask
                            ->patternBlocks([
                                'money' => fn(Mask $mask) => $mask
                                    ->numeric()
                                    ->thousandsSeparator(',')
                                    ->decimalSeparator('.'),
                            ])
                            ->pattern('đ money'),
                        )->reactive(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('coupon_code')->label('Mã giảm giá')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('coupon_start_date')->label('Ngày bắt đầu')->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('coupon_end_date')->label('Ngày kết thúc')->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('discount_value')->label('Giá trị giảm')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCoupons::route('/'),
        ];
    }
}

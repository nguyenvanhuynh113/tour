<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Tour;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Quản lý Tour';
    protected static ?string $navigationLabel = 'Đặt chuyến';

    protected static ?string $slug = 'dat-ve';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('booking_number')
                            ->label('Mã HD')
                            ->disabled()
                            ->default('BK-' . rand(99999, 10000000)),
                        Select::make('id_tour')
                            ->label('Chọn chuyến đi')
                            ->options(\App\Models\Tour::query()->pluck('title', 'id'))
                            ->relationship('tour', 'title')
                            ->afterStateUpdated(fn($state, \Closure $set) => $set('unit_prices', Tour::find($state)?->normal_prices ?? 0))
                            ->reactive()
                            ->searchable()->preload(),
                        Forms\Components\TextInput::make('unit_prices')
                            ->label("Don Giá")
                            ->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            )->reactive(),

                        Forms\Components\TextInput::make('customer_name')
                            ->label('Tên khách hàng')
                            ->placeholder('Nhập tên khách hàng')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Địa chỉ email')
                            ->email()
                            ->placeholder('example@email.com')
                            ->required(),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Số điện thoại')
                            ->tel()
                            ->mask(fn(Mask $mask) => $mask->pattern('+{84}(000)000-00-00'))
                            ->numeric()
                            ->required(),
                        TextInput::make('person')
                            ->numeric()
                            ->required()
                            ->afterStateUpdated(function ($state, Closure $get, Closure $set) {
                                $quantity = $get('person');
                                $unit_prices = $get('unit_prices');
                                $set('total_prices', intval($quantity) * intval($unit_prices));
                            })
                            ->reactive(),
                        TextInput::make('total_prices')
                            ->numeric()
                            ->required()
                            ->label("Giá")
                            ->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            )->reactive(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->label('Mã HĐ')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()->sortable()->label('Khách hàng'),
                Tables\Columns\TextColumn::make('person')
                    ->sortable()->label('Số lượng vé'),
                Tables\Columns\TextColumn::make('total_prices')
                    ->searchable()
                    ->money('vnd')
                    ->label('Tổng')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/y H:i')->sortable()
                    ->label('Ngày đặt'),
                BadgeColumn::make('status')->label('Trạng thái')
                    ->sortable()
                    ->colors([
                        'success' => 'success',
                        'danger' => 'fails',
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

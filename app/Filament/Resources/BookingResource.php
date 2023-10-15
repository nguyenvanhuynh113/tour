<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Chuyến đi';
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
                            ->relationship('tour', 'title')
                            ->searchable()->preload(),
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
                            ->minValue(1),
                        TextInput::make('prices')
                            ->label("Giá")->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            ),
                        Forms\Components\DatePicker::make('booking_date')
                            ->default(Carbon::now())
                            ->label('Ngày đặt'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

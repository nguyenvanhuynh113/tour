<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartureDateResource\Pages;
use App\Filament\Resources\DepartureDateResource\RelationManagers;
use App\Models\DepartureDate;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DepartureDateResource extends Resource
{
    protected static ?string $model = DepartureDate::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Chuyến đi';
    protected static ?string $navigationLabel = 'Lịch trình';

    protected static ?string $slug = 'lich-trinh';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('id_tour')
                            ->label('Chuyến đi')
                            ->relationship('tour', 'title')
                            ->searchable()
                            ->columnSpan('full')
                            ->preload(),
                        Forms\Components\DatePicker::make('departure_date')
                            ->label('Ngày khởi hành')
                            ->minDate(Carbon::now())
                            ->default(Carbon::now())
                            ->required(),
                        TextInput::make('prices')
                            ->required()
                            ->label("Giá vé theo ngày đặt")->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            ),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tour.title')->label('Chuyến đi')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure_date')
                    ->label('Ngày khởi hành'),
                Tables\Columns\TextColumn::make('prices')->sortable()
                    ->label('Giá / ngày khởi hành')
            ])->filters([
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
            'index' => Pages\ListDepartureDates::route('/'),
            'create' => Pages\CreateDepartureDate::route('/create'),
            'edit' => Pages\EditDepartureDate::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class DepartureDatesRelationManager extends RelationManager
{
    protected static string $relationship = 'departure_dates';
    protected static ?string $label='Lịch trình chuyến đi';
    protected static ?string $recordTitleAttribute = 'departure_date';

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
                            ->label("Giá vé theo ngày đặt")
                            ->mask(fn(TextInput\Mask $mask) => $mask
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
                Tables\Columns\TextColumn::make('id')->sortable()->label('Mã'),
                Tables\Columns\TextColumn::make('departure_date')
                    ->label('Ngày khởi hành'),
                Tables\Columns\TextColumn::make('prices')
                    ->sortable()
                    ->money('VND')
                    ->label('Giá / ngày khởi hành')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

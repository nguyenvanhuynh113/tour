<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Quản lý Tour';
    protected static ?string $navigationLabel = 'Giao dịch';

    protected static ?string $slug = 'thanh-toan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Toggle::make('status')->label('THANH TOÁN THÀNH CÔNG')
                            ->onColor('success')
                            ->offColor('danger')->columnSpan('full'),
                        Select::make('id_user')->label('Tài khoản GD')
                            ->relationship('user', 'name'),
                        TextInput::make('order_code')->label('Mã đơn hàng'),
                        TextInput::make('transaction_no')->label('Mã giao dịch'),
                        TextInput::make('bank_code')->label('Mã ngân hàng'),
                        TextInput::make('amount')->label('Tổng HD')
                            ->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            ),
                        TextInput::make('card_type')->label('Loại hình thanh toán'),
                        TextInput::make('order_info')->label('Nội dung'),
                        DatePicker::make('created_at')->label('Ngày GD')

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_code')
                    ->label('Mã ĐH')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('transaction_no')
                    ->label('Mã GD')->searchable()
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('bank_code')
                    ->label('Ngân hàng')->searchable()
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('vnd')->searchable()
                    ->label('Thanh toán'),
                Tables\Columns\TextColumn::make('card_type')
                    ->label('Loại hình')->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_info')
                    ->limit('20')
                    ->label('Nội dung')
                    ->sortable(),
                IconColumn::make('status')->label('Trạng thái')
                    ->boolean()->sortable()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày GD')->date('d/m/y H:i')->sortable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

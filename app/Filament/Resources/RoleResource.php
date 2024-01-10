<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $slug = 'vai-tro';
    protected static ?string $navigationGroup = 'Quản Lý Người Dùng';
    protected static ?string $label = 'Vài trò';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Forms create and edit category
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()->maxLength(255)->label('Vai trò')
                            ->placeholder('Nhập tên vài trò cho người dùng hệ thống')
                            ->unique(ignoreRecord: true),
                        Select::make('permissions')
                            ->multiple()->label('Quyền hạn')
                            ->relationship('permissions', 'name')->preload()
                    ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Hiển thị danh sách vài trò của người dùng
                Tables\Columns\TextColumn::make('id')
                    ->label('Mã')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')->sortable()
                    ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày cập nhật')
                    ->sortable()
                    ->dateTime('Y-m-d'),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
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

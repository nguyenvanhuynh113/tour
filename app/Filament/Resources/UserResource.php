<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Quản Lý Người Dùng';
    protected static ?string $navigationLabel = 'Người dùng';
    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'nguoi-dung';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->placeholder('Nhập họ tên người dùng')
                            ->label('Tên')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->placeholder('Nhập địa chỉ email')
                            ->label('Địa chỉ email')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->default(Carbon::now()),
                        Forms\Components\TextInput::make('password')
                            ->label('Mật khẩu')
                            ->password()
                            ->minLength(8)
                            ->placeholder('Mật khẩu tối thểu 8 kí tự')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(\Filament\Resources\Pages\Page $livewire) => $livewire instanceof Pages\CreateUser)
                            ->maxLength(255),
                        Forms\Components\Select::make('roles')
                            ->multiple()->label('Vai trò')
                            ->relationship('roles', 'name')->preload(),
                    ])->columnSpan(2)->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Tên')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Địa chỉ email')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Xác thực')->sortable()
                    ->dateTime('Y-m-d'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')->sortable()
                    ->dateTime('Y-m-d'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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

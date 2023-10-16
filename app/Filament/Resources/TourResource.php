<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers\DepartureDatesRelationManager;
use App\Models\Tour;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationGroup = 'Quản lý Tour';
    protected static ?string $navigationLabel = 'Chuyến đi';

    protected static ?string $slug = 'chuyen-di';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Tiêu đề')->columnSpan('full')
                            ->placeholder('Nhập tiêu đề')
                            ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                if (!$get('is_slug_changed_manually') && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->reactive()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(255),
                        Select::make('id_place')
                            ->label('Địa điểm')
                            ->relationship('place', 'name')
                            ->preload()->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Tên địa điểm')
                                    ->placeholder('VD: Phú Quốc,...')
                                    ->unique()
                                    ->maxLength(255)
                                    ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                        if (!$get('is_slug_changed_manually') && filled($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->reactive(),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('image')->nullable()
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Tạo địa điểm du lịch')
                                    ->modalButton('Tạo địa điểm')
                                    ->modalWidth('lg');
                            }),
                        Select::make('id_type')
                            ->label('Loại hình')
                            ->relationship('type', 'name')
                            ->preload()->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Tên loại hình')
                                    ->placeholder('VD: Tour du lịch,...')
                                    ->unique()
                                    ->maxLength(255)
                                    ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                                        if (!$get('is_slug_changed_manually') && filled($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->reactive(),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Tạo loại hình tour')
                                    ->modalButton('Tạo loại hình')
                                    ->modalWidth('lg');
                            }),
                        Select::make('coupons')->label('Mã giảm giá')
                            ->multiple()
                            ->relationship('coupons', 'coupon_code')
                            ->searchable()
                            ->preload()->createOptionForm([
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
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Tạo mã giảm giá')
                                    ->modalButton('Tạo mã giảm giá')
                                    ->modalWidth('lg');
                            }),
                        TextInput::make('total_date_tour')
                            ->label('Tổng số ngày / chuyến')
                            ->numeric()->minValue(1)->required(),
                        Forms\Components\DatePicker::make('star_date_tour')
                            ->label('Ngày bắt đầu')
                            ->default(Carbon::now()),
                        Forms\Components\DatePicker::make('end_date_tour')
                            ->label('Ngày kết thúc')
                            ->default(Carbon::now()),
                        TextInput::make('normal_prices')
                            ->label("Giá dự kiến / người")->mask(fn(TextInput\Mask $mask) => $mask
                                ->patternBlocks([
                                    'money' => fn(Mask $mask) => $mask
                                        ->numeric()
                                        ->thousandsSeparator(',')
                                        ->decimalSeparator('.'),
                                ])
                                ->pattern('đ money'),
                            ),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->minValue(1)->maxValue(100)
                            ->label('Số lượng vé / chuyến')
                            ->required(),
                        TextInput::make('des_address')
                            ->label('Mô tả ngắn địa chỉ')
                            ->columnSpan('full')
                            ->placeholder('VD: Quận 9, Thành phố Hồ Chí Minh, Việt Nam')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->required()
                            ->imagePreviewHeight('150')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->label('Hình ảnh')->columnSpan('full'),
                        Forms\Components\RichEditor::make('information')
                            ->label('Thông tin')->columnSpan('full'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->limit(50)
                    ->searchable()->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Hình ảnh')
                    ->circular(),
                Tables\Columns\TextColumn::make('normal_prices')
                    ->money('VND')
                    ->label('Giá')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')->sortable()
                    ->dateTime('d/m/y H:i'),
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
            DepartureDatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
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

<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
    protected static ?string $slug = 'tao-moi-bai-viet';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_publisher'] = auth()->id();

        return $data;
    }
}

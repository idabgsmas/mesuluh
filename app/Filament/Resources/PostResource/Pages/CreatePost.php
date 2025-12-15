<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Otomatis isi user_id dengan user yang sedang login
        $data['user_id'] = auth()->id();
        
        // Default status: Draft (ID 1)
        $data['status_id'] = 1;

        return $data;
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('Dibaca?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Waktu Masuk')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Pesan terbaru di atas
            ->actions([
                Tables\Actions\ViewAction::make(), // Agar bisa baca detail pesan
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}

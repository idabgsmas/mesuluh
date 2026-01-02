<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Kelola Kutipan')
                ->schema([
                    Forms\Components\Textarea::make('content')->required()->rows(3),
                    Forms\Components\TextInput::make('author')->label('Penulis/Tokoh'),
                    Forms\Components\Select::make('position')
                        ->options([
                            'home_featured' => 'Halaman Depan (Besar)',
                            'home_sidebar' => 'Halaman Depan (Sidebar Kanan)',
                            'sidebar' => 'Sidebar (Kanan)',
                        ])->required(),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')->label('Kutipan')->limit(50),
                Tables\Columns\TextColumn::make('author')->label('Penulis/Tokoh'),
                Tables\Columns\TextColumn::make('position')->label('Posisi Ditampilkan'),
                Tables\Columns\BooleanColumn::make('is_active')->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('position')->options([
                    'home_featured' => 'Halaman Beranda (Utama)',
                    'home_sidebar' => 'Halaman Beranda (Sidebar Kanan)',
                    'sidebar' => 'Sidebar (Kanan)',
                ])->label('Posisi Ditampilkan'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Set; 
use Illuminate\Support\Str; 

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // Ikon di Sidebar
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    // Label Menu di Sidebar
    protected static ?string $navigationLabel = 'Kategori Tulisan';
    protected static ?string $navigationGroup = 'Manajemen Konten Tulisan'; // Mengelompokkan menu
    protected static ?int $navigationSort = 2;

    // Label Model
    protected static ?string $recordTitleAttribute = 'Kategori Tulisan';
    protected static ?string $modelLabel = 'Kategori Tulisan';
    protected static ?string $pluralModelLabel = 'Kategori Tulisan';

    public static function canViewAny(): bool
    {
        // Boleh dilihat oleh siapa saja KECUALI Penulis
        return ! auth()->user()->isPenulis();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // Bereaksi saat selesai ngetik
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))), // Auto Slug
            
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->readOnly() // Biar gak diubah manual sembarangan
                    ->maxLength(255),

                ColorPicker::make('text_color')
                    ->label('Warna Teks')
                    ->label('Warna Teks Label'),
                
                ColorPicker::make('bg_color')
                    ->label('Warna Background Label'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('text_color')
                    ->label('Warna Teks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bg_color')
                    ->label('Warna Background')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

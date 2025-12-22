<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    // Ikon Menu di Sidebar
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    // Label Menu di Sidebar
    protected static ?string $navigationLabel = 'Tag Tulisan';
    protected static ?string $navigationGroup = 'Manajemen Konten Tulisan'; // Mengelompokkan menu
    protected static ?int $navigationSort = 3;

    // Label Model
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Tag Tulisan';
    protected static ?string $pluralModelLabel = 'Tag Tulisan';

    public static function canViewAny(): bool
    {
        // Boleh dilihat oleh siapa saja KECUALI Penulis
        return ! auth()->user()->isPenulis();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        // Input Nama Tag
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tag')
                            ->required()
                            ->maxLength(255)
                            // Auto-generate Slug saat mengetik nama
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                            ),

                        // Input Slug (URL)
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tag')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}

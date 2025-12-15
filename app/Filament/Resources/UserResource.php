<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // Ikon Menu di Sidebar
    protected static ?string $navigationIcon = 'heroicon-o-user';

    // Label Menu di Sidebar
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Pengguna'; // Mengelompokkan menu
    protected static ?int $navigationSort = 1;

    // Label Model
    protected static ?string $recordTitleAttribute = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // Aktif saat diketik
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('username', Str::slug($state))), // Auto-generate slug
                Forms\Components\TextInput::make('username')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true) // Pastikan unik
                    ->hint('Digunakan untuk link profil (contoh: ida-bagus-mas)'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role_id')
                    ->label('Peran Pengguna')
                    ->relationship('role', 'name') // Ambil relasi 'role', tampilkan kolom 'name'
                    ->searchable() // Biar bisa dicari ketik
                    ->preload()    // Biar datanya dimuat langsung (user experience lebih cepat)
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('bio')
                    ->label('Bio')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('avatar')
                    ->label('Avatar URL')
                    ->helperText('Masukkan URL gambar foto pengguna')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.name') // Ambil nama dari relasi role
                    ->label('Peran Pengguna')
                    ->badge() // Biar tampilannya kotak berwarna (seperti badge)
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'danger',   // Merah untuk Admin
                        'Editor' => 'warning', // Kuning untuk Editor
                        'Penulis' => 'success', // Hijau untuk Penulis
                        default => 'gray',
                    })
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('bio')
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

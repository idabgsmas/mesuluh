<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Filament\Resources\SubscriberResource\RelationManagers;
use App\Models\Subscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    // Ikon surat agar sesuai konteks Newsletter
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    // Label Menu di Sidebar
    protected static ?string $navigationLabel = 'Pelanggan';
    protected static ?string $navigationGroup = 'Interaksi Pembaca'; // Mengelompokkan menu
    protected static ?int $navigationSort = 1;

    // Label Model
    protected static ?string $recordTitleAttribute = 'email';
    protected static ?string $modelLabel = 'Pelanggan';
    protected static ?string $pluralModelLabel = 'Pelanggan';

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form sederhana jika Admin ingin input manual
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('contoh@email.com')
                            ->columnSpanFull(),
                    ])
                    ->maxWidth('md') // Agar form tidak terlalu lebar
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Email
                Tables\Columns\TextColumn::make('email')
                    ->label('Email Pelanggan')
                    ->searchable() // Bisa dicari
                    ->copyable()   // Bisa diklik copy
                    ->copyMessage('Email disalin')
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary'),

                // Kolom Tanggal Gabung
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung Sejak')
                    ->dateTime('d M Y, H:i') // Format tanggal cantik
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Yang terbaru paling atas
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(), // Tombol hapus per baris
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Hapus banyak sekaligus
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
            'index' => Pages\ListSubscribers::route('/'),
            'create' => Pages\CreateSubscriber::route('/create'),
            'edit' => Pages\EditSubscriber::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Menghitung user yang daftar HARI INI
        return static::getModel()::whereDate('created_at', now())->count() ?: null;
    }
    
    // Kita kasih warna Biru (info) untuk pelanggan baru
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}

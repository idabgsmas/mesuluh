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
use Filament\Notifications\Notification;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Kotak Masuk';
    protected static ?string $recordTitleAttribute = 'Kotak Masuk';
    protected static ?string $modelLabel = 'Kotak Masuk';
    protected static ?string $pluralModelLabel = 'Kotak Masuk';
    protected static ?string $navigationGroup = 'Interaksi Pembaca';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kita kosongkan saja form utama ini
                // Karena kita akan menampilkan detailnya lewat Modal di Tabel
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Penanda Status (Titik Warna)
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-s-check-circle')
                    ->falseIcon('heroicon-s-envelope')
                    ->trueColor('gray')
                    ->falseColor('primary')
                    ->tooltip(fn ($state) => $state ? 'Sudah Dibaca' : 'Belum Dibaca'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email Pengirim')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            
            // 1. Matikan Link Edit Default saat baris diklik
            ->recordUrl(null)
            
            // 2. Ganti aksi klik baris menjadi aksi 'view_detail' yang kita buat di bawah
            ->recordAction('view_detail')
            
            ->actions([
                // CUSTOM ACTION: LIHAT DETAIL & TANDAI DIBACA
                Tables\Actions\Action::make('view_detail')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->color(fn (ContactMessage $record) => $record->is_read ? 'gray' : 'primary')
                    ->modalHeading('Detail Pesan Masuk')
                    ->modalDescription('Baca isi pesan dari pengunjung.')
                    ->modalSubmitActionLabel('Tandai Sudah Dibaca') // Ubah label tombol submit
                    ->modalCancelActionLabel('Tutup')
                    ->mountUsing(fn (Forms\ComponentContainer $form, ContactMessage $record) => $form->fill([
                        'name' => $record->name,
                        'email' => $record->email,
                        'subject' => $record->subject,
                        'message' => $record->message,
                    ]))
                    // Isi Modal (Form Read-only)
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama')
                                    ->disabled(), // Tidak bisa diedit
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->disabled(),
                            ]),
                        Forms\Components\TextInput::make('subject')
                            ->label('Subjek')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(6)
                            ->disabled()
                            ->columnSpanFull(),
                        
                        // Menampilkan status saat ini
                        Forms\Components\Placeholder::make('status_info')
                            ->label('Status')
                            ->content(fn ($record) => $record->is_read ? '✅ Sudah Dibaca' : '📩 Belum Dibaca'),
                    ])
                    // Logika saat tombol "Tandai Sudah Dibaca" diklik
                    ->action(function (ContactMessage $record) {
                        $record->update(['is_read' => true]);
                        
                        Notification::make()
                            ->title('Pesan ditandai sudah dibaca')
                            ->success()
                            ->send();
                    })
                    // Sembunyikan tombol "Tandai Dibaca" jika memang sudah dibaca
                    ->modalSubmitAction(fn ($action, $record) => $record->is_read ? false : $action),

                Tables\Actions\DeleteAction::make()
                    ->label(''), // Hapus label agar hanya ikon tong sampah (opsional)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Opsional: Tandai banyak sekaligus
                    Tables\Actions\BulkAction::make('mark_read')
                        ->label('Tandai Sudah Dibaca')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            // Kita HAPUS halaman Create dan Edit agar Admin tidak bisa buat/edit pesan palsu
        ];
    }
}

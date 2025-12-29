<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. ACTION PENULIS: AJUKAN REVIEW
            // (Tidak berubah: Hanya untuk Penulis saat Draft/Revisi)
            Actions\Action::make('submit_review')
                ->label('Ajukan Review')
                ->icon('heroicon-m-paper-airplane')
                ->color('primary')
                ->visible(fn () => auth()->user()->isPenulis() && in_array($this->record->status_id, [1, 4]))
                ->action(function () {
                    $this->record->update(['status_id' => 2]); 
                    Notification::make()->title('Tulisan diajukan untuk review!')->success()->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            // 2. ACTION EDITOR/ADMIN: PUBLISH (FAST TRACK)
            // Actions\Action::make('publish')
            //     ->label('Terbitkan')
            //     ->icon('heroicon-m-check-badge')
            //     ->color('success')
            //     // PERUBAHAN DISINI:
            //     // Muncul untuk Non-Penulis (Admin/Editor)
            //     // DAN Statusnya boleh: Draft (1), Review (2), atau Revisi (4)
            //     ->visible(fn () => !auth()->user()->isPenulis() && in_array($this->record->status_id, [1, 2, 4]))
            //     ->action(function () {
            //         // Cek data di database (apakah user sudah isi field published_at?)
            //         $existingDate = $this->record->published_at;

            //         // Logika Penentuan Tanggal:
            //         // Jika user sudah set tanggal (misal dijadwalkan besok), GUNAKAN ITU.
            //         // Jika user kosongkan (null), baru kita set 'now()'.
            //         $publishDate = $existingDate ?? now();

            //         $this->record->update([
            //             'status_id' => 3, // Published
            //             'published_at' => $publishDate,
            //             'revision_notes' => null,
            //         ]);
            //         // Ubah pesan notifikasi agar lebih informatif
            //         if ($publishDate > now()) {
            //             Notification::make()->title('Tulisan dijadwalkan tayang pada ' . $publishDate->format('d M H:i'))->success()->send();
            //         } else {
            //             Notification::make()->title('Tulisan berhasil diterbitkan sekarang!')->success()->send();
            //         }
            //     }),
            
            Actions\Action::make('publish')
                ->label('Terbitkan')
                ->icon('heroicon-m-check-badge')
                ->color('success')
                ->visible(fn () => !auth()->user()->isPenulis() && in_array($this->record->status_id, [1, 2, 4]))
                ->action(function () {
                    // 1. Ambil data terbaru dari form yang sedang dibuka
                    $formData = $this->form->getState();

                    // 2. Ambil nilai published_at dari form
                    // Jika form kosong, maka otomatis pakai waktu sekarang (now())
                    $publishDate = $formData['published_at'] ?? now();

                    // 3. Update data ke database
                    $this->record->update([
                        'status_id' => 3, // Set status ke Published
                        'published_at' => $publishDate,
                        'revision_notes' => null,
                    ]);

                    // 4. Sinkronisasi tampilan form agar status berubah tanpa reload
                    $this->refreshFormData(['status_id', 'published_at', 'revision_notes']);

                    // Notifikasi sukses yang informatif
                    $message = $publishDate > now() 
                        ? 'Tulisan dijadwalkan tayang pada ' . \Carbon\Carbon::parse($publishDate)->format('d M Y H:i')
                        : 'Tulisan berhasil diterbitkan sekarang!';
                        
                    Notification::make()->title($message)->success()->send();
                }),

            // 3. ACTION EDITOR: MINTA REVISI
            // (Tidak berubah: Hanya muncul jika status Review)
            Actions\Action::make('request_revision')
                ->label('Minta Revisi')
                ->icon('heroicon-m-arrow-path')
                ->color('warning')
                ->visible(fn () => !auth()->user()->isPenulis() && $this->record->status_id === 2)
                ->form([
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('Catatan Revisi')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status_id' => 4, 
                        'revision_notes' => $data['notes']
                    ]);
                    Notification::make()->title('Status diubah menjadi Revisi')->warning()->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            // 4. ACTION EDITOR: TOLAK
            // (Tidak berubah: Hanya muncul jika status Review)
            Actions\Action::make('reject')
                ->label('Tolak Tulisan')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->visible(fn () => !auth()->user()->isPenulis() && $this->record->status_id === 2)
                ->form([
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status_id' => 5, 
                        'revision_notes' => $data['notes']
                    ]);
                    Notification::make()->title('Tulisan ditolak')->danger()->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            // 5. ACTION ADMIN/EDITOR: BATALKAN TERBIT (UNPUBLISH)
            // Kasus: Tulisan sudah terlanjur tayang, tapi ada kesalahan fatal / ingin ditarik.
            Actions\Action::make('unpublish')
                ->label('Batalkan Terbit (Takedown)')
                ->icon('heroicon-m-archive-box-x-mark')
                ->color('gray')
                // Muncul jika Status = Published (3) DAN User bukan Penulis
                ->visible(fn () => !auth()->user()->isPenulis() && $this->record->status_id === 3)
                ->requiresConfirmation()
                ->modalHeading('Tarik Kembali Tulisan?')
                ->modalDescription('Tulisan akan dikembalikan ke status Draft dan hilang dari website.')

                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label('Alasan Penarikan (Takedown)')
                        ->placeholder('Contoh: Ada kesalahan data fatal pada paragraf 2.')
                        ->required()
                        ->rows(3),
                ])

                ->action(function (array $data) {
                    $this->record->update([
                        'status_id' => 4, // SAYA SARANKAN KE 'REVISI' (ID 4) BUKAN DRAFT (ID 1)
                        'published_at' => null, // Hapus tanggal terbit
                        'is_featured' => false,
                        'revision_notes' => 'STATUS UNPUBLISHED: ' . $data['reason'], // Simpan Alasan
                    ]);
                    
                    Notification::make()->title('Tulisan berhasil ditarik (Unpublished)')->success()->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
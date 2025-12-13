<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- KOLOM KIRI (70% Layar) ---
                Group::make()
                    ->schema([
                        Section::make('Konten Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Tulisan')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->readOnly()
                                    ->unique(ignoreRecord: true), // Unik, kecuali punya diri sendiri saat edit

                                Textarea::make('excerpt')
                                    ->label('Ringkasan Singkat')
                                    ->rows(3)
                                    ->maxLength(255)
                                    ->helperText('Ditampilkan di kartu halaman depan.'),

                                RichEditor::make('content')
                                    ->label('Isi Tulisan')
                                    ->required()
                                    ->fileAttachmentsDirectory('posts/content-images') // Simpan gambar konten di folder rapi
                                    ->columnSpanFull(),
                            ]),
                        
                        Section::make('SEO & Meta')
                            ->schema([
                                TextInput::make('seo_title')->label('Judul SEO (Opsional)'),
                                Textarea::make('seo_description')->label('Deskripsi SEO (Opsional)'),
                            ])->collapsed(), // Bisa dilipat biar gak menuhin layar
                    ])
                    ->columnSpan(['lg' => 2]), // Lebar 2/3 layar

                // --- KOLOM KANAN (30% Layar) ---
                Group::make()
                    ->schema([
                        Section::make('Publikasi')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('Gambar Sampul')
                                    ->image()
                                    ->directory('posts/thumbnails') // Folder penyimpanan
                                    ->required(),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name') // Ambil dari tabel categories
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                
                                TagsInput::make('tags')
                                    ->label('Tags')
                                    ->placeholder('Ketik tag baru dan tekan Enter')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ' ']) // Bisa tekan Tab atau Spasi untuk bikin tag
                                    
                                    // 1. Tampilkan sugesti dari tag yang sudah ada
                                    ->suggestions(
                                        fn () => Tag::all()->pluck('name')->toArray()
                                    )
                                    
                                    // 2. Load data saat edit artikel (Ambil dari database)
                                    ->loadStateFromRelationshipsUsing(function ($component, $record) {
                                        if ($record) {
                                            $component->state($record->tags->pluck('name')->toArray());
                                        }
                                    })
                                    
                                    // 3. Simpan data saat form disubmit
                                    ->saveRelationshipsUsing(function ($record, $state) {
                                        // $state berisi array nama tag: ["Bali", "Adat"]
                                        $tagIds = [];
                                        foreach ($state as $tagName) {
                                            // Buat atau Cari Tag berdasarkan nama
                                            $slug = Str::slug($tagName);
                                            $tag = Tag::firstOrCreate(
                                                ['slug' => $slug],
                                                ['name' => $tagName]
                                            );
                                            $tagIds[] = $tag->id;
                                        }
                                        // Hubungkan (Sync) ke Post
                                        $record->tags()->sync($tagIds);
                                    }),

                                Select::make('user_id')
                                    ->label('Penulis')
                                    ->relationship('user', 'name')
                                    ->default(fn () => auth()->id()) // Otomatis pilih diri sendiri
                                    ->required()
                                    ->searchable(),

                                DateTimePicker::make('published_at')
                                    ->label('Tanggal Tayang'),

                                Select::make('status_id')
                                    ->label('Status')
                                    ->relationship('status', 'name')
                                    ->required()
                                    ->native(false), // Tampilan dropdown lebih modern

                                Toggle::make('is_featured')
                                    ->label('Jadikan Headline?')
                                    ->onColor('success')
                                    ->offColor('gray'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]), // Lebar 1/3 layar
            ])
            ->columns(3); // Total grid 3 kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Sampul')
                    ->square(),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30), // Batasi panjang judul biar tabel rapi

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->badge() // Tampil seperti lencana
                    ->color(fn ($state) => match ($state) {
                        'Sulur' => 'success', // Hijau (contoh)
                        'Suluh' => 'warning', // Kuning
                        'Singgah' => 'info',  // Biru
                        'Taut' => 'danger',   // Merah
                        default => 'gray',
                    }),

                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Published' => 'success',
                        'Review' => 'warning',
                        'Draft' => 'gray',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->toggleable(), // Bisa disembunyikan

                TextColumn::make('published_at')
                    ->label('Tayang')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Urutkan dari yang terbaru
            ->filters([
                // Nanti kita tambah filter di sini
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}

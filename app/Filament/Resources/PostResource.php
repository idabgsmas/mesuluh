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

    // Ikon Menu di Sidebar
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    
    // Label Menu di Sidebar
    protected static ?string $navigationLabel = 'Tulisan';
    protected static ?string $navigationGroup = 'Manajemen Konten Tulisan'; // Mengelompokkan menu
    protected static ?int $navigationSort = 1;

    // Label Model
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Tulisan';
    protected static ?string $pluralModelLabel = 'Tulisan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- BAGIAN ATAS: ALERT CATATAN REVISI/PENOLAKAN ---
                Forms\Components\Section::make('Catatan dari Editor')
                    ->schema([
                        Forms\Components\Placeholder::make('notes_display')
                            ->label('')
                            ->content(fn ($record) => $record?->revision_notes)
                            ->extraAttributes(['class' => 'text-danger-600 font-bold bg-red-50 p-4 rounded-lg border border-red-200']),
                    ])
                    // Hanya muncul jika ada catatan DAN statusnya Revisi (4) atau Ditolak (5)
                    ->visible(fn ($record) => $record && $record->revision_notes && in_array($record->status_id, [4, 5]))
                    ->columnSpanFull(),
                // ----------------------------------------------------
                // --- KOLOM KIRI (70% Layar) ---
                Group::make()
                    ->schema([
                        Section::make('Konten Utama')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Tulisan')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    // KUNCI JIKA DITOLAK (ID 5)
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                TextInput::make('slug')
                                    ->required()
                                    ->readOnly()
                                    ->unique(ignoreRecord: true) // Unik, kecuali punya diri sendiri saat edit
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                Textarea::make('excerpt')
                                    ->label('Ringkasan Singkat')
                                    ->rows(3)
                                    ->maxLength(255)
                                    ->helperText('Ditampilkan di kartu halaman depan.')
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                RichEditor::make('content')
                                    ->label('Isi Tulisan')
                                    ->required()
                                    ->fileAttachmentsDirectory('posts/content-images') // Simpan gambar konten di folder rapi
                                    ->columnSpanFull()
                                    ->disabled(fn ($record) => $record?->status_id === 5),
                            ]),
                        
                        Section::make('SEO Metadata')
                            ->description('Atur bagaimana tulisan ini muncul di Google dan Media Sosial')
                            ->collapsible() // Bisa di-expand/collapse
                            ->disabled(fn ($record) => $record?->status_id === 5)
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('Judul SEO')
                                    ->helperText('Jika dikosongkan, akan menggunakan judul asli tulisan.')
                                    ->maxLength(60),
                                    
                                Textarea::make('seo_description')
                                    ->label('Deskripsi SEO (Meta Description)')
                                    ->helperText('Ringkasan pendek (rekomendasi 150-160 karakter) untuk hasil pencarian Google.')
                                    ->rows(3)
                                    ->maxLength(160),

                                FileUpload::make('seo_image')
                                    ->label('Gambar Preview Medsos (Open Graph)')
                                    ->image()
                                    ->directory('seo-previews')
                                    ->helperText('Gambar yang akan muncul saat link dibagikan ke WA/FB/IG.'),
                            ]),
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
                                    ->required()
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name') // Ambil dari tabel categories
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->disabled(fn ($record) => $record?->status_id === 5),
                                
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
                                    })
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                // Select::make('user_id')
                                //     ->label('Penulis')
                                //     ->relationship('user', 'name')
                                //     ->default(fn () => auth()->id()) // Otomatis pilih diri sendiri
                                //     ->required()
                                //     ->searchable(),

                                DateTimePicker::make('published_at')
                                    ->label('Tanggal Tayang')
                                    ->visible(fn () => !auth()->user()->isPenulis()) // Hanya tampilkan untuk Admin/Editor,
                                    ->disabled(fn ($record) => $record?->status_id === 5),

                                // Select::make('status_id')
                                //     ->label('Status')
                                //     ->relationship('status', 'name')
                                //     ->required()
                                //     ->native(false), // Tampilan dropdown lebih modern

                                Toggle::make('is_featured')
                                    ->label('Jadikan Headline?')
                                    ->onColor('success')
                                    ->offColor('gray')
                                    ->visible(fn () => !auth()->user()->isPenulis()) // Hanya tampilkan untuk Admin/Editor
                                    ->disabled(fn ($record) => $record?->status_id === 5),
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
                // ImageColumn::make('thumbnail')
                //     ->label('Sampul')
                //     ->square(),

                TextColumn::make('title')
                    ->label('Judul Tulisan')
                    ->searchable()
                    ->sortable()
                    ->limit(30) // Batasi panjang judul biar tabel rapi
                    ->toolTip(fn (TextColumn $column): ?string => $column->getState()), // Tampilkan full judul saat hover

                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->toggleable(), // Bisa disembunyikan

                TextColumn::make('category.name')
                    ->label('Kategori Tulisan')
                    ->searchable()
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
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Published' => 'success',
                        'Review' => 'warning',
                        'Draft' => 'gray',
                        'Ditolak' => 'danger',
                        'Revisi' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('published_at')
                    ->label('Tayang')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('views')
                    ->label('Dibaca')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc') // Urutkan dari yang terbaru
            ->filters([
                Tables\Filters\SelectFilter::make('user.name')
                    ->label('Penulis')
                    ->relationship('user', 'name'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->relationship('status', 'name'),
                Tables\Filters\SelectFilter::make('is_featured')
                    ->label('Tulisan Unggulan')
                    ->options([
                        1 => 'Tulisan Unggulan',
                        0 => 'Tidak Unggulan',
                    ]),
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

    // Batasi tampilan data di Filament berdasarkan peran pengguna
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if ($user->isPenulis()) {
            // Penulis hanya melihat tulisannya sendiri
            $query->where('user_id', $user->id);
        } else {
            // Admin & Editor melihat SEMUA tulisan, KECUALI Draft milik orang lain
            $query->where(function ($q) use ($user) {
                $q->where('status_id', '!=', 1) // Bukan Draft (ID 1)
                  ->orWhere('user_id', $user->id); // Kecuali Draft itu milik Admin/Editor sendiri
            });
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        // Asumsi: status_id 2 adalah "Menunggu Review/Pending"
        // Jika hitungannya 0, kita return null agar badge hilang (tidak semak)
        return static::getModel()::where('status_id', 2)->count() ?: null;
    }

    // Mengatur Warna (Merah jika ada antrian)
    public static function getNavigationBadgeColor(): ?string
    {
        // Jika ada lebih dari 0 antrian, warnanya 'danger' (merah), kalau tidak 'gray'
        return static::getModel()::where('status_id', 2)->count() > 0 ? 'danger' : 'gray';
    }
}

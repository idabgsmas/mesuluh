<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Menghasilkan file sitemap.xml otomatis';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // 1. Tambahkan Halaman Statis
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
                ->add(Url::create('/tentang-kami')->setPriority(0.8))
                ->add(Url::create('/kontak')->setPriority(0.8));

        // 2. Tambahkan Semua Artikel yang SUDAH TERBIT (Status ID 3)
        Post::where('status_id', 3)->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/tulisan/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.9)
            );
        });

        // 3. Tambahkan Halaman Kategori
        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create("/kategori/{$category->slug}")
                    ->setPriority(0.7)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap berhasil diperbarui!');
    }
}
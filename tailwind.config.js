import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                // Palet Warna Mesuluh
                mesuluh: {
                    primary: '#8b004b', // Magenta Gelap
                    cream: '#fff8e8',   // Latar Krem (Paper-like)
                    dark: '#1a1a1a',    // Hitam tidak pekat (untuk teks)
                }
            },
            fontFamily: {
                // Font Pilihan Kamu
                serif: ['Suranna', ...defaultTheme.fontFamily.serif], // Untuk Judul
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],   // Untuk Isi
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
};
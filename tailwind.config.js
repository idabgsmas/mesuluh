import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
            animation: {
                'blob': 'blob 7s infinite', // Animasi 'blob' berdurasi 7 detik
            },
            keyframes: {
                blob: {
                    '0%': {
                        transform: 'translate(0px, 0px) scale(1)',
                    },
                    '33%': {
                        transform: 'translate(30px, -50px) scale(1.1)', // Gerak ke kanan-atas, membesar dikit
                    },
                    '66%': {
                        transform: 'translate(-20px, 20px) scale(0.9)', // Gerak ke kiri-bawah, mengecil dikit
                    },
                    '100%': {
                        transform: 'translate(0px, 0px) scale(1)', // Kembali ke posisi awal
                    },
                },
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
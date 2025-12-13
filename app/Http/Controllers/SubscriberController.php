<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Manual (Agar kita bisa atur redirect error-nya)
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar sebelumnya.',
        ]);

        // JIKA GAGAL: Kembali ke #newsletter dengan pesan error
        if ($validator->fails()) {
            return redirect(url()->previous() . '#newsletter')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 2. Simpan ke Database
        Subscriber::create([
            'email' => $request->email
        ]);

        // 3. JIKA SUKSES: Kembali ke #newsletter dengan pesan sukses
        return redirect(url()->previous() . '#newsletter')
                    ->with('success', 'Terima kasih! Anda telah berhasil berlangganan.');
    }
}
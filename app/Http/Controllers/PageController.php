<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class PageController extends Controller
{
    public function storeContact(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Simpan ke Database
        ContactMessage::create($validated);

        // 3. Kembali ke halaman kontak dengan pesan sukses
        return redirect()->route('contact')->with('success', 'Terima kasih! Pesan Anda telah kami terima.');
    }
    
    public function about()
    {
        // Mengambil data anggota tim dari database, diurutkan berdasarkan sort_order
        $teamMembers = TeamMember::orderBy('sort_order', 'asc')->get();
        
        return view('pages.about', compact('teamMembers'));
    }

    public function pedoman()
    {
        return view('pages.pedoman');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
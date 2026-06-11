<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    // Tampilkan form pendaftaran
    public function showForm($id_event)
    {
        $event = Event::where('eve_id_event', $id_event)->firstOrFail();
        return view('pendaftaran.form', compact('event'));
    }

    // Proses submit form pendaftaran
    public function store(Request $request)
    {
        $request->validate([
            'pdf_id_event' => 'required|exists:mst_event,eve_id_event',
            'pdf_nama'     => 'required|string|max:255',
            'pdf_email'    => 'required|email|max:255',
            'pdf_no_hp'    => 'required|string|max:20',
        ], [
            'pdf_id_event.required' => 'Event tidak ditemukan.',
            'pdf_id_event.exists'   => 'Event tidak valid.',
            'pdf_nama.required'     => 'Nama wajib diisi.',
            'pdf_email.required'    => 'Email wajib diisi.',
            'pdf_email.email'       => 'Format email tidak valid.',
            'pdf_no_hp.required'    => 'No HP wajib diisi.',
        ]);

        // Cek kuota event
        $event = Event::where('eve_id_event', $request->pdf_id_event)->firstOrFail();
        $jumlahDaftar = Pendaftaran::where('pdf_id_event', $request->pdf_id_event)
                                   ->whereIn('pdf_status', ['pending', 'approved'])
                                   ->count();

        if ($jumlahDaftar >= $event->eve_kuota) {
            return back()->withErrors(['kuota' => 'Maaf, kuota event ini sudah penuh!'])->withInput();
        }

        // Cek apakah user sudah daftar event yang sama
        $userId = auth()->id(); // null kalau belum login
        if ($userId) {
            $sudahDaftar = Pendaftaran::where('pdf_id_event', $request->pdf_id_event)
                                      ->where('pdf_id_users', $userId)
                                      ->whereIn('pdf_status', ['pending', 'approved'])
                                      ->exists();
            if ($sudahDaftar) {
                return back()->withErrors(['duplikat' => 'Kamu sudah mendaftar event ini!'])->withInput();
            }
        }

        // Generate PK string
        $idPendaftaran = 'PDF-' . strtoupper(Str::random(8)) . '-' . now()->format('YmdHis');

        Pendaftaran::create([
            'pdf_id_pendaftaran' => $idPendaftaran,
            'pdf_id_users'       => $userId,
            'pdf_id_event'       => $request->pdf_id_event,
            'pdf_nama'           => $request->pdf_nama,
            'pdf_email'          => $request->pdf_email,
            'pdf_no_hp'          => $request->pdf_no_hp,
            'pdf_status'         => 'pending',
            'pdf_createDate'     => now(),
        ]);

        return redirect()->route('pendaftaran.sukses', ['id' => $idPendaftaran]);
    }

    // Halaman sukses
    public function sukses($id)
    {
        $pendaftaran = Pendaftaran::with('event')
                                  ->where('pdf_id_pendaftaran', $id)
                                  ->firstOrFail();
        return view('pendaftaran.sukses', compact('pendaftaran'));
    }
}
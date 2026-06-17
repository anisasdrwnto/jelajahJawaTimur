<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('eve_tanggal', 'asc')->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'eve_nama_event'  => 'required|string|max:255',
            'eve_deskripsi'   => 'required|string',
            'eve_kategori'    => 'required|string|max:100',
            'eve_tanggal'     => 'required|date',
            'eve_lokasi'      => 'required|string|max:255',
            'eve_kuota'       => 'required|integer|min:1',
            'eve_gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('eve_gambar')) {
            $gambarPath = $request->file('eve_gambar')->store('events', 'public');
        }

        Event::create([
            'eve_id_event'    => 'EVE-' . strtoupper(Str::random(8)),
            'eve_nama_event'  => $request->eve_nama_event,
            'eve_deskripsi'   => $request->eve_deskripsi,
            'eve_kategori'    => $request->eve_kategori,
            'eve_tanggal'     => $request->eve_tanggal,
            'eve_lokasi'      => $request->eve_lokasi,
            'eve_gambar'      => $gambarPath,
            'eve_kuota'       => $request->eve_kuota,
            'eve_createBy'    => auth()->id(),
            'eve_createDate'  => now(),
        ]);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::where('eve_id_event', $id)->firstOrFail();
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::where('eve_id_event', $id)->firstOrFail();

        $request->validate([
            'eve_nama_event'  => 'required|string|max:255',
            'eve_deskripsi'   => 'required|string',
            'eve_kategori'    => 'required|string|max:100',
            'eve_tanggal'     => 'required|date',
            'eve_lokasi'      => 'required|string|max:255',
            'eve_kuota'       => 'required|integer|min:1',
            'eve_gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = $event->eve_gambar;
        if ($request->hasFile('eve_gambar')) {
            // Hapus gambar lama kalau ada
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('eve_gambar')->store('events', 'public');
        }

        $event->update([
            'eve_nama_event'  => $request->eve_nama_event,
            'eve_deskripsi'   => $request->eve_deskripsi,
            'eve_kategori'    => $request->eve_kategori,
            'eve_tanggal'     => $request->eve_tanggal,
            'eve_lokasi'      => $request->eve_lokasi,
            'eve_gambar'      => $gambarPath,
            'eve_kuota'       => $request->eve_kuota,
        ]);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil diupdate!');
    }

    public function destroy($id)
    {
        $event = Event::where('eve_id_event', $id)->firstOrFail();

        if ($event->eve_gambar) {
            Storage::disk('public')->delete($event->eve_gambar);
        }

        $event->delete();

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil dihapus!');
    }
}
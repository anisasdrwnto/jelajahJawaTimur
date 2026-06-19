@extends('layouts.admin') 

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">🗂️ Manajemen Event</h4>
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
            + Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Event</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Kuota</th>
                        <th>Pendaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $i => $event)
                    <tr>
                        <td>{{ $events->firstItem() + $i }}</td>
                        <td class="fw-semibold">{{ $event->eve_nama_event }}</td>
                        <td><span class="badge bg-info text-dark">{{ $event->eve_kategori }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($event->eve_tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $event->eve_lokasi }}</td>
                        <td>{{ $event->eve_kuota }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $event->pendaftaran()->count() }}
                                / {{ $event->eve_kuota }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.event.edit', $event->eve_id_event) }}"
                               class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('admin.event.destroy', $event->eve_id_event) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus event ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada event nih 😅</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $events->links() }}</div>
</div>
@endsection
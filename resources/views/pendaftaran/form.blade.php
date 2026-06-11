@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h2 class="fw-bold mb-1">Daftar Event</h2>
    <p class="text-muted mb-4">{{ $event->eve_nama_event }}</p>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('pendaftaran.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pdf_id_event" value="{{ $event->eve_id_event }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="pdf_nama" class="form-control @error('pdf_nama') is-invalid @enderror"
                           value="{{ old('pdf_nama', auth()->user()?->mus_name) }}" placeholder="Nama lengkap kamu">
                    @error('pdf_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="pdf_email" class="form-control @error('pdf_email') is-invalid @enderror"
                           value="{{ old('pdf_email', auth()->user()?->mus_email) }}" placeholder="email@kamu.com">
                    @error('pdf_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                    <input type="text" name="pdf_no_hp" class="form-control @error('pdf_no_hp') is-invalid @enderror"
                           value="{{ old('pdf_no_hp') }}" placeholder="08xxxxxxxxxx">
                    @error('pdf_no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Info Event --}}
                <div class="bg-light rounded p-3 mb-4 small">
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="text-muted">📅 Tanggal</span><br>
                            <strong>{{ \Carbon\Carbon::parse($event->eve_tanggal)->translatedFormat('d F Y') }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">📍 Lokasi</span><br>
                            <strong>{{ $event->eve_lokasi }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">🎟️ Kategori</span><br>
                            <strong>{{ $event->eve_kategori }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">👥 Sisa Kuota</span><br>
                            <strong>
                                {{ $event->eve_kuota - $event->pendaftarans()->whereIn('pdf_status',['pending','approved'])->count() }}
                                orang
                            </strong>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                    Daftar Sekarang 🚀
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Tambah Event Baru</h4>
        <a href="{{ route('admin.event.index') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Event</label>
                        <input type="text" name="eve_nama_event" class="form-control @error('eve_nama_event') is-invalid @enderror" value="{{ old('eve_nama_event') }}" required>
                        @error('eve_nama_event') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="eve_kategori" class="form-select @error('eve_kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Festival" {{ old('eve_kategori') == 'Festival' ? 'selected' : '' }}>Festival</option>
                            <option value="Petualangan" {{ old('eve_kategori') == 'Petualangan' ? 'selected' : '' }}>Petualangan</option>
                            <option value="Kebudayaan" {{ old('eve_kategori') == 'Kebudayaan' ? 'selected' : '' }}>Kebudayaan</option>
                            <option value="Lainnya" {{ old('eve_kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('eve_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="eve_tanggal" class="form-control @error('eve_tanggal') is-invalid @enderror" value="{{ old('eve_tanggal') }}" required>
                        @error('eve_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="eve_lokasi" class="form-control @error('eve_lokasi') is-invalid @enderror" value="{{ old('eve_lokasi') }}" required>
                        @error('eve_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Kuota Peserta</label>
                        <input type="number" name="eve_kuota" class="form-control @error('eve_kuota') is-invalid @enderror" value="{{ old('eve_kuota') }}" min="1" required>
                        @error('eve_kuota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Event (Opsional)</label>
                    <input type="file" name="eve_gambar" class="form-control @error('eve_gambar') is-invalid @enderror" accept="image/*">
                    <div class="form-text">Maksimal 2MB (jpg, jpeg, png, webp).</div>
                    @error('eve_gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Deskripsi Event</label>
                    <textarea name="eve_deskripsi" class="form-control @error('eve_deskripsi') is-invalid @enderror" rows="5" required>{{ old('eve_deskripsi') }}</textarea>
                    @error('eve_deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">Simpan Event</button>
            </form>
        </div>
    </div>
</div>
@endsection

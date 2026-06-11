@extends('layouts.app')

@section('content')
<div class="container py-5 text-center" style="max-width: 500px;">
    <div class="display-1 mb-3">🎉</div>
    <h2 class="fw-bold">Pendaftaran Berhasil!</h2>
    <p class="text-muted mb-4">
        Kamu berhasil daftar event <strong>{{ $pendaftaran->event->eve_nama_event }}</strong>.
        Kami akan konfirmasi via email segera ya!
    </p>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-start p-4">
            <h6 class="fw-bold text-muted mb-3">📋 Detail Pendaftaran</h6>
            <table class="table table-borderless small mb-0">
                <tr><td class="text-muted">ID Pendaftaran</td><td><code>{{ $pendaftaran->pdf_id_pendaftaran }}</code></td></tr>
                <tr><td class="text-muted">Nama</td><td>{{ $pendaftaran->pdf_nama }}</td></tr>
                <tr><td class="text-muted">Email</td><td>{{ $pendaftaran->pdf_email }}</td></tr>
                <tr><td class="text-muted">No. HP</td><td>{{ $pendaftaran->pdf_no_hp }}</td></tr>
                <tr><td class="text-muted">Status</td><td><span class="badge bg-warning text-dark">Pending</span></td></tr>
            </table>
        </div>
    </div>

    <a href="{{ url('/home') }}" class="btn btn-outline-primary">← Kembali ke Home</a>
</div>
@endsection
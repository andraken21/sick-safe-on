@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

{{-- PERBAIKAN: CSS dipindah ke @push('styles') agar dimuat di <head>, bukan di dalam body --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-card">

        <main class="main-content">

            <h2 class="section-title">Resep Masuk</h2>

            {{-- TABS --}}
            <div class="tabs">
                <div class="tab active" data-tab="validasi">Menunggu Validasi (3)</div>
                <div class="tab"        data-tab="pembayaran">Menunggu Pembayaran (2)</div>
                <div class="tab"        data-tab="diproses">Diproses (4)</div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="resepTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="selected">
                            <td>1</td>
                            <td>RSP-2024-0051</td>
                            <td>Andi Setiawan</td>
                            <td>Dr. Budi Santoso</td>
                            <td>20 Mei 2024</td>
                            <td>Menunggu Validasi</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DETAIL RESEP --}}
            <div class="detail-section">
                <h3>Detail Resep</h3>
                <div class="detail-grid">
                    <div>
                        <div class="detail-item"><strong>Pasien:</strong> Andi Setiawan</div>
                        <div class="detail-item"><strong>Dokter:</strong> Dr. Budi Santoso</div>
                        <div class="detail-item"><strong>Catatan:</strong> Sesudah makan</div>
                    </div>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th>Dosis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Paracetamol</td>
                                    <td>3x sehari</td>
                                    <td>10 Tablet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="actions">
                <button class="btn-custom btn-outline">Tolak</button>
                <button class="btn-custom btn-primary">Validasi</button>
                <button class="btn-custom btn-dark">Validasi &amp; Proses</button>
            </div>

        </main>
    </div>
</div>
@endsection

{{-- PERBAIKAN: @push('scripts') bekerja karena layouts/app.blade.php sudah punya @stack('scripts') --}}
@push('scripts')
<script>
    // TAB SWITCHER
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // PILIH BARIS TABLE
    document.querySelectorAll('#resepTable tbody tr').forEach(row => {
        row.addEventListener('click', function () {
            document.querySelectorAll('#resepTable tbody tr').forEach(r => r.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
</script>
@endpush
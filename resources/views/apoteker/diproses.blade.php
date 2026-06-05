@extends('layouts.app')

@section('title', 'Diproses - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
@endpush

@section('content')

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <main class="main-content">

            <div class="page-header">
                <h2 class="section-title">Resep Diproses</h2>
                <p class="section-subtitle">Pantau progress pengerjaan resep yang sedang diproses</p>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="resepTable" class="resep-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Resep</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Estimasi Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="selected">
                            <td>1</td>
                            <td><span class="resep-id">RSP-2024-0044</span></td>
                            <td>Budi Hartono</td>
                            <td>Dr. Budi Santoso</td>
                            <td>18 Mei 2024</td>
                            <td>20 Mei 2024, 14:00</td>
                            <td><span class="status-badge status-success">Diproses</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><span class="resep-id">RSP-2024-0045</span></td>
                            <td>Maya Sari</td>
                            <td>Dr. Citra Dewi</td>
                            <td>18 Mei 2024</td>
                            <td>20 Mei 2024, 15:30</td>
                            <td><span class="status-badge status-success">Diproses</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><span class="resep-id">RSP-2024-0046</span></td>
                            <td>Agus Salim</td>
                            <td>Dr. Ahmad Fauzi</td>
                            <td>19 Mei 2024</td>
                            <td>21 Mei 2024, 09:00</td>
                            <td><span class="status-badge status-success">Diproses</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><span class="resep-id">RSP-2024-0047</span></td>
                            <td>Lina Permata</td>
                            <td>Dr. Budi Santoso</td>
                            <td>19 Mei 2024</td>
                            <td>21 Mei 2024, 10:30</td>
                            <td><span class="status-badge status-success">Diproses</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DETAIL --}}
            <div class="detail-section">
                <div class="detail-header">
                    <h3>Detail Resep</h3>
                    <span class="detail-id">RSP-2024-0044</span>
                </div>
                <div class="detail-grid">
                    <div class="detail-info">
                        <div class="detail-item">
                            <span class="detail-label">Pasien</span>
                            <span class="detail-value">Budi Hartono</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Dokter</span>
                            <span class="detail-value">Dr. Budi Santoso</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Estimasi Selesai</span>
                            <span class="detail-value">20 Mei 2024, 14:00</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Progress</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 65%"></div>
                            </div>
                            <span class="detail-value">65% Selesai</span>
                        </div>
                    </div>
                    <div class="detail-obat">
                        <h4 class="obat-title">Daftar Obat</h4>
                        <table class="obat-table">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Metformin 500mg</td>
                                    <td>2× sehari</td>
                                    <td>60 Tablet</td>
                                    <td><span class="status-badge status-success">Siap</span></td>
                                </tr>
                                <tr>
                                    <td>Glibenclamide</td>
                                    <td>1× sehari</td>
                                    <td>30 Tablet</td>
                                    <td><span class="status-badge status-warning">Disiapkan</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="actions">
                    <button class="btn-custom btn-outline" id="btn-open-riwayat">
                        Lihat Riwayat
                    </button>
                    <button class="btn-custom btn-dark" id="btn-open-selesai">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Tandai Selesai
                    </button>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div class="modal-overlay" id="modal-konfirmasi" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-title" id="modal-title"></span>
            <button class="modal-close" id="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-content-center">
                <h2 id="modal-question"></h2>
                <p id="modal-desc"></p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-secondary" id="modal-cancel">Batal</button>
            <button class="btn-modal-primary"   id="modal-confirm">Ya, Konfirmasi</button>
        </div>
    </div>
</div>

{{-- TOAST CONTAINER --}}
<div class="toast-container" id="toast-container"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/dashboardApoteker.js') }}"></script>
@endpush
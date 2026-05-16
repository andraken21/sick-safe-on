@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

@section('content')

<div class="dashboard-wrapper">

    <link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">
        <div class="dashboard-card">

        {{-- MAIN --}}
        <main class="main-content">

            <h2 class="section-title">Resep Masuk</h2>

            {{-- TABS --}}
            <div class="tabs">
                <div class="tab active">Menunggu Validasi (3)</div>
                <div class="tab">Menunggu Pembayaran (2)</div>
                <div class="tab">Diproses (4)</div>
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

            {{-- DETAIL --}}
            <div class="detail-section">

                <h3>Detail Resep</h3>

                <div class="detail-grid">

                    <div>
                        <div class="detail-item">
                            <strong>Pasien:</strong> Andi Setiawan
                        </div>

                        <div class="detail-item">
                            <strong>Dokter:</strong> Dr. Budi Santoso
                        </div>

                        <div class="detail-item">
                            <strong>Catatan:</strong> Sesudah makan
                        </div>
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
                <button class="btn-custom btn-dark">Validasi & Proses</button>
            </div>

        </main>

    </div>

</div>

@endsection

@push('scripts')
<script>

    // TAB
    document.querySelectorAll('.tab').forEach(tab => {

        tab.addEventListener('click', function() {

            document.querySelectorAll('.tab').forEach(t => {
                t.classList.remove('active');
            });

            this.classList.add('active');

        });

    });

    // TABLE ROW
    document.querySelectorAll('#resepTable tbody tr').forEach(row => {

        row.addEventListener('click', function() {

            document.querySelectorAll('#resepTable tbody tr').forEach(r => {
                r.classList.remove('selected');
            });

            this.classList.add('selected');

        });

    });

</script>
@endpush
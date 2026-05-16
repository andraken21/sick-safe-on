@extends('layouts.app')

@section('title', 'Resep Digital')

@section('content')
<link rel="stylesheet" href="{{ asset('css/resepDigital.css') }}">

<div class="admin-page">

    <div class="page-header">
        <div>
            <h1>Resep Digital</h1>
            <p>Kelola seluruh resep pasien secara digital</p>
        </div>

        <button class="primary-btn">
            <i class="fa-solid fa-plus"></i>
            Tambah Resep
        </button>
    </div>

    {{-- FILTER --}}
    <div class="filter-bar">
        <input type="text" placeholder="Cari pasien / nomor resep...">

        <select>
            <option>Semua Status</option>
            <option>Diproses</option>
            <option>Selesai</option>
            <option>Pending</option>
        </select>

        <button class="filter-btn">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No Resep</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>RSP-2026-001</td>
                    <td>Kenzi</td>
                    <td>Dr. Rahman</td>
                    <td>16 Mei 2026</td>
                    <td>
                        <span class="badge success">Selesai</span>
                    </td>
                    <td>
                        <button class="action-btn view">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button class="action-btn edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>RSP-2026-002</td>
                    <td>Yeeree</td>
                    <td>Dr. Nanda</td>
                    <td>16 Mei 2026</td>
                    <td>
                        <span class="badge warning">Pending</span>
                    </td>
                    <td>
                        <button class="action-btn view">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button class="action-btn edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
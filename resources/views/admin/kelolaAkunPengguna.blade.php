@extends('layouts.app')

@section('title', 'Kelola Akun Pengguna - Sick Safe ON')

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/kelolaAkunPengguna.css') }}">

    {{-- MAIN AREA --}}
    <div class="dash-main">
<!-- 
        {{-- TOPBAR --}}
        <div class="dash-topbar">
            <div>
                <div class="topbar-title">Kelola Akun Pengguna</div>
                <div class="topbar-sub">Kelola semua akun pengguna sistem</div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Refresh">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
                <button class="topbar-btn btn-add-user">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div> -->

        {{-- CONTENT --}}
        <div class="dash-content">

            {{-- FILTERS & SEARCH --}}
            <div class="filter-section">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari nama, email, atau ID pengguna..." class="search-input">
                </div>

                <div class="filter-group">
                    <select class="filter-select">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="dokter">Dokter</option>
                        <option value="apoteker">Apoteker</option>
                        <option value="resepsionis">Resepsionis</option>
                    </select>

                    <select class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>

                    <button class="btn-filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
            </div>

            {{-- USERS TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table users-table">
                        <thead>
                            <tr>
                                <th width="5%"><input type="checkbox" class="check-all"></th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th>Tgl Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- User 1 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">DR</div>
                                        <div class="user-info">
                                            <div class="user-name">Dr. Reza Pratama</div>
                                            <div class="user-id">ID: USR-2026-001</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:reza@sicksafe.com" class="email-link">reza@sicksafe.com</a></td>
                                <td><span class="role-badge role-dokter">Dokter</span></td>
                                <td>+62 812-3456-7890</td>
                                <td>15 Jan 2026</td>
                                <td><span class="status-badge status-aktif">✓ Aktif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- User 2 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">AP</div>
                                        <div class="user-info">
                                            <div class="user-name">Aprina Santoso</div>
                                            <div class="user-id">ID: USR-2026-002</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:aprina@sicksafe.com" class="email-link">aprina@sicksafe.com</a></td>
                                <td><span class="role-badge role-apoteker">Apoteker</span></td>
                                <td>+62 812-9876-5432</td>
                                <td>20 Jan 2026</td>
                                <td><span class="status-badge status-aktif">✓ Aktif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- User 3 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">SI</div>
                                        <div class="user-info">
                                            <div class="user-name">Siti Indriyani</div>
                                            <div class="user-id">ID: USR-2026-003</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:siti@sicksafe.com" class="email-link">siti@sicksafe.com</a></td>
                                <td><span class="role-badge role-resepsionis">Resepsionis</span></td>
                                <td>+62 812-1111-2222</td>
                                <td>10 Feb 2026</td>
                                <td><span class="status-badge status-aktif">✓ Aktif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- User 4 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">BW</div>
                                        <div class="user-info">
                                            <div class="user-name">Budi Wijaya</div>
                                            <div class="user-id">ID: USR-2026-004</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:budi@sicksafe.com" class="email-link">budi@sicksafe.com</a></td>
                                <td><span class="role-badge role-dokter">Dokter</span></td>
                                <td>+62 812-3333-4444</td>
                                <td>25 Feb 2026</td>
                                <td><span class="status-badge status-nonaktif">✗ Non-Aktif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- User 5 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">NP</div>
                                        <div class="user-info">
                                            <div class="user-name">Nurul Putri</div>
                                            <div class="user-id">ID: USR-2026-005</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:nurul@sicksafe.com" class="email-link">nurul@sicksafe.com</a></td>
                                <td><span class="role-badge role-apoteker">Apoteker</span></td>
                                <td>+62 812-5555-6666</td>
                                <td>01 Mar 2026</td>
                                <td><span class="status-badge status-aktif">✓ Aktif</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button class="btn-action btn-more" title="Lebih Lanjut">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan <strong>1-5</strong> dari <strong>24</strong> pengguna
                </div>
                <div class="pagination">
                    <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">5</button>
                    <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}

<script src="{{ asset('js/manageUsers.js') }}"></script>
</div>
@endsection
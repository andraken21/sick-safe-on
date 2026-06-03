@extends('layouts.app')

@section('title', 'Kelola Akun Pengguna - Sick Safe ON')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kelolaAkunPengguna.css') }}">
@endpush


@section('content')

<div class="dashboard-wrap">

    <div class="dash-main">

        {{-- CONTENT --}}
        <div class="dash-content">

            {{-- FILTER & SEARCH --}}
            <div class="filter-section">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput"
                           placeholder="Cari nama, email, atau ID pengguna..."
                           class="search-input">
                </div>
                <div class="filter-group">
                    <select class="filter-select" id="filterRole">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="dokter">Dokter</option>
                        <option value="apoteker">Apoteker</option>
                    </select>
                    <select class="filter-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                    <button class="btn-tambah" id="btnAddUser">
                        <i class="fa-solid fa-user-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table users-table">
                        <thead>
                            <tr>
                                <th width="4%"><input type="checkbox" id="checkAll"></th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th>Tgl Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            {{-- Diisi oleh manageUsers.js --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="pagination-wrap">
                <div class="pagination-info" id="paginationInfo">Memuat data...</div>
                <div class="pagination" id="pagination"></div>
            </div>

        </div>
    </div>

    {{-- ========================================
         MODAL: TAMBAH / EDIT
    ======================================== --}}
    <div class="modal-overlay" id="modalAddEdit">
        <div class="modal-box">

            <div class="modal-header">
                <div class="modal-header-icon" id="modalAddEditIcon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title"   id="modalAddEditTitle">Tambah Pengguna Baru</div>
                    <div class="modal-subtitle" id="modalAddEditSub">Isi data pengguna dengan lengkap</div>
                </div>
                <button class="modal-close" type="button"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal-body">
                <p class="form-section-label"><i class="fa-solid fa-id-card"></i> Informasi Dasar</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inputName">Nama Lengkap <span style="color:#DC2626">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="inputName" placeholder="Contoh: Dr. Reza Pratama">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">No. Telepon</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" id="inputPhone" placeholder="+62 8xx-xxxx-xxxx">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Alamat Email <span style="color:#DC2626">*</span></label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="inputEmail" placeholder="email@sicksafe.com">
                    </div>
                </div>

                <p class="form-section-label" style="margin-top:6px"><i class="fa-solid fa-shield-halved"></i> Hak Akses</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="inputRole">Role <span style="color:#DC2626">*</span></label>
                        <select id="inputRole">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="dokter">Dokter</option>
                            <option value="apoteker">Apoteker</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputStatus">Status Akun</label>
                        <select id="inputStatus">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="passwordGroup">
                    <label for="inputPassword">Password</label>
                    <div class="pwd-wrap">
                        <input type="password" id="inputPassword" placeholder="Min. 8 karakter">
                        <button class="btn-pwd-toggle" type="button" id="btnPwdToggle">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-modal-cancel" type="button">
                    <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                </button>
                <button class="btn-modal-save" type="button" id="btnSaveUser">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengguna
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================
         MODAL: DETAIL
    ======================================== --}}
    <div class="modal-overlay" id="modalDetail">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-header-icon">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Detail Pengguna</div>
                    <div class="modal-subtitle">Informasi lengkap akun</div>
                </div>
                <button class="modal-close" type="button"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="detail-header-card">
                    <div class="detail-avatar-lg" id="detailAvatarLg">--</div>
                    <div class="detail-header-info">
                        <div class="detail-main-name" id="detailMainName">—</div>
                        <div class="detail-main-id"   id="detailMainId">—</div>
                    </div>
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Email</label>
                        <div class="detail-val" id="detailEmail">—</div>
                    </div>
                    <div class="detail-item">
                        <label>Telepon</label>
                        <div class="detail-val" id="detailPhone">—</div>
                    </div>
                    <div class="detail-item">
                        <label>Role</label>
                        <div class="detail-val" id="detailRole">—</div>
                    </div>
                    <div class="detail-item">
                        <label>Status</label>
                        <div class="detail-val" id="detailStatus">—</div>
                    </div>
                    <div class="detail-item">
                        <label>Tanggal Dibuat</label>
                        <div class="detail-val" id="detailCreated">—</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" type="button">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ========================================
         MODAL: KONFIRMASI
    ======================================== --}}
    <div class="modal-overlay" id="modalConfirm">
        <div class="modal-box" style="max-width:380px">
            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#F59E0B,#D97706)">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Konfirmasi Aksi</div>
                    <div class="modal-subtitle">Pastikan sebelum melanjutkan</div>
                </div>
                <button class="modal-close" type="button"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body" style="padding-top:16px;padding-bottom:16px">
                <div class="confirm-icon" id="confirmIcon">⚠️</div>
                <div class="confirm-msg"  id="confirmMsg">Apakah Anda yakin?</div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" type="button">Batal</button>
                <button class="btn-modal-save"   type="button" id="btnConfirmOk"
                        style="background:linear-gradient(135deg,#DC2626,#B91C1C);box-shadow:0 2px 10px rgba(220,38,38,.3)">
                    <i class="fa-solid fa-check"></i> Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/kelolaAkunPengguna.js') }}"></script>
@endpush

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
        <div class="dash-content">

            {{-- ── FLASH MESSAGES ─────────────────────────── --}}
            @if (session('success'))
                <div class="alert alert-success" style="
                    background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;
                    padding:12px 16px;border-radius:10px;margin-bottom:16px;
                    display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" style="
                    background:#fef2f2;border:1px solid #fecaca;color:#991b1b;
                    padding:12px 16px;border-radius:10px;margin-bottom:16px;
                    display:flex;align-items:center;gap:10px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            {{-- ── FILTER & SEARCH (GET form) ─────────────── --}}
            <form method="GET" action="{{ route('kelolaAkunPengguna') }}" class="filter-section" id="filterForm">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau email pengguna..."
                           class="search-input">
                </div>
                <div class="filter-group">
                    <select class="filter-select" name="role" id="filterRole"
                            onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Role</option>
                        @foreach (['Pasien','Dokter','Apoteker','Admin'] as $r)
                            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-tambah" style="background:linear-gradient(135deg,#475569,#334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    <button type="button" class="btn-tambah" id="btnAddUser">
                        <i class="fa-solid fa-user-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </form>

            {{-- ── TABEL PENGGUNA ──────────────────────────── --}}
            <div class="dash-card">
                <div class="table-wrap">
                    <table class="dash-table users-table">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th>Tgl Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
<<<<<<< HEAD
                            @forelse($users ?? [] as $user)
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ strtoupper(substr($user->nama ?? 'U', 0, 2)) }}</div>
                                        <div class="user-info">
                                            <div class="user-name">{{ $user->nama }}</div>
                                            <div class="user-id">ID: USR-{{ str_pad((string) $user->ID_User, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="mailto:{{ $user->email }}" class="email-link">{{ $user->email }}</a></td>
                                <td><span class="role-badge role-{{ strtolower($user->role) }}">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ $user->no_telp ?? '-' }}</td>
                                <td>{{ optional($user->created_at)->format('d M Y') ?? '-' }}</td>
                                <td><span class="status-badge status-{{ strtolower($user->status ?? 'aktif') }}">{{ ucfirst($user->status ?? 'aktif') }}</span></td>
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
                            @empty
                            {{-- User 1 --}}
                            <tr>
                                <td><input type="checkbox" class="check-row"></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">DR</div>
                                        <div class="user-info">
                                            <div class="user-name">Dr. Reza Pratama</div>
                                            <div class="user-id">ID: USR-2026-001</div>
=======
                            @forelse ($users as $user)
                                @php
                                    $roleColor = match($user->role) {
                                        'Admin'    => '#7c3aed',
                                        'Dokter'   => '#0369a1',
                                        'Apoteker' => '#0d9488',
                                        'Pasien'   => '#16a34a',
                                        default    => '#64748b',
                                    };
                                    $roleIcon = match($user->role) {
                                        'Admin'    => 'fa-shield-halved',
                                        'Dokter'   => 'fa-user-doctor',
                                        'Apoteker' => 'fa-mortar-pestle',
                                        'Pasien'   => 'fa-hospital-user',
                                        default    => 'fa-user',
                                    };
                                    $initials = strtoupper(substr($user->nama, 0, 2));
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div style="
                                                width:36px;height:36px;border-radius:50%;
                                                background:{{ $roleColor }}22;color:{{ $roleColor }};
                                                display:flex;align-items:center;justify-content:center;
                                                font-weight:700;font-size:.8rem;flex-shrink:0;">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div style="font-weight:600;color:#1e293b;">{{ $user->nama }}</div>
                                                <div style="font-size:.72rem;color:#94a3b8;">
                                                    ID #{{ $user->id_user }}
                                                </div>
                                            </div>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                                        </div>
                                    </td>
                                    <td style="color:#475569;">{{ $user->email }}</td>
                                    <td>
                                        <span style="
                                            display:inline-flex;align-items:center;gap:5px;
                                            padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;
                                            background:{{ $roleColor }}18;color:{{ $roleColor }};">
                                            <i class="fa-solid {{ $roleIcon }}" style="font-size:.65rem;"></i>
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td style="color:#475569;">{{ $user->no_telp ?? '-' }}</td>
                                    <td style="color:#64748b;font-size:.82rem;">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            {{-- Tombol Edit --}}
                                            <button type="button"
                                                    class="btn-aksi btn-edit"
                                                    title="Edit"
                                                    onclick="bukaModalEdit({{ $user->id_user }})">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            @if ($user->id_user !== auth()->id())
                                                <form method="POST"
                                                      action="{{ route('admin.akun.destroy', $user->id_user) }}"
                                                      onsubmit="return confirm('Hapus akun {{ addslashes($user->nama) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-aksi btn-hapus" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span style="color:#cbd5e1;font-size:.75rem;padding:4px;">Anda</span>
                                            @endif
                                        </div>
<<<<<<< HEAD
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
=======
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                                        <i class="fa-solid fa-users-slash" style="font-size:2rem;"></i>
                                        <p style="margin-top:10px;">Tidak ada pengguna ditemukan.</p>
                                    </td>
                                </tr>
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── PAGINATION ──────────────────────────────── --}}
            <div class="pagination-wrap">
                <div class="pagination-info">
<<<<<<< HEAD
                    Menampilkan <strong>{{ method_exists($users ?? null, 'firstItem') ? ($users->firstItem() ?? 0) : 0 }}-{{ method_exists($users ?? null, 'lastItem') ? ($users->lastItem() ?? 0) : 0 }}</strong> dari <strong>{{ method_exists($users ?? null, 'total') ? $users->total() : 0 }}</strong> pengguna
=======
                    Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                    dari {{ $users->total() }} pengguna
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
                </div>
                <div class="pagination">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

<<<<<<< HEAD
</div>
@endsection
=======
    {{-- ════════════════════════════════════════════════
         MODAL: TAMBAH PENGGUNA
    ════════════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalTambah" style="display:none;">
        <div class="modal-box">

            <div class="modal-header">
                <div class="modal-header-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Tambah Pengguna Baru</div>
                    <div class="modal-subtitle">Isi data pengguna dengan lengkap</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalTambah')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.akun.store') }}">
                @csrf
                <div class="modal-body">

                    {{-- Informasi Dasar --}}
                    <p class="form-section-label"><i class="fa-solid fa-id-card"></i> Informasi Dasar</p>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nama" placeholder="Contoh: Dr. Reza Pratama"
                                       value="{{ old('nama') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" name="no_telp" placeholder="+62 8xx-xxxx-xxxx"
                                       value="{{ old('no_telp') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>NIK</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-id-badge"></i>
                                <input type="text" name="nik" placeholder="16 digit NIK"
                                       maxlength="16" value="{{ old('nik') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-calendar"></i>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" name="alamat" placeholder="Alamat lengkap"
                                       value="{{ old('alamat') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Email <span style="color:#DC2626">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="email@sicksafe.com"
                                   value="{{ old('email') }}" required>
                        </div>
                    </div>

                    {{-- Hak Akses --}}
                    <p class="form-section-label" style="margin-top:6px;">
                        <i class="fa-solid fa-shield-halved"></i> Hak Akses
                    </p>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Role <span style="color:#DC2626">*</span></label>
                            <select name="role" id="tambahRole" required
                                    onchange="toggleFieldRole(this.value, 'tambah')">
                                <option value="">-- Pilih Role --</option>
                                @foreach (['Pasien','Dokter','Apoteker','Admin'] as $r)
                                    <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password <span style="color:#DC2626">*</span></label>
                            <div class="pwd-wrap">
                                <input type="password" name="password" id="tambahPassword"
                                       placeholder="Min. 8 karakter" required>
                                <button class="btn-pwd-toggle" type="button"
                                        onclick="togglePwd('tambahPassword', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Konfirmasi Password <span style="color:#DC2626">*</span></label>
                            <div class="pwd-wrap">
                                <input type="password" name="password_confirmation"
                                       placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>

                    {{-- Field khusus Dokter --}}
                    <div id="tambah-field-dokter" style="display:none;">
                        <p class="form-section-label"><i class="fa-solid fa-stethoscope"></i> Data Dokter</p>
                        <div class="form-group">
                            <label>Spesialis <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-stethoscope"></i>
                                <input type="text" name="spesialis" placeholder="Contoh: Umum, Jantung, Anak..."
                                       value="{{ old('spesialis') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Field khusus Pasien --}}
                    <div id="tambah-field-pasien" style="display:none;">
                        <p class="form-section-label"><i class="fa-solid fa-notes-medical"></i> Data Pasien</p>
                        <div class="form-row">
                            <div class="form-group">
                                <label>No. BPJS</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-id-card"></i>
                                    <input type="text" name="no_bpjs" placeholder="No. BPJS (opsional)"
                                           maxlength="13" value="{{ old('no_bpjs') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Riwayat Penyakit</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                    <input type="text" name="riwayat_penyakit" placeholder="Contoh: Diabetes, Hipertensi"
                                           value="{{ old('riwayat_penyakit') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Validasi error --}}
                    @if ($errors->any())
                        <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;
                                    padding:10px 14px;border-radius:8px;margin-top:10px;font-size:.82rem;">
                            <ul style="margin:0;padding-left:16px;">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalTambah')">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Pengguna
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- ════════════════════════════════════════════════
         MODAL: EDIT PENGGUNA
         Data diisi via JS fetch ke route edit
    ════════════════════════════════════════════════ --}}
    <div class="modal-overlay" id="modalEdit" style="display:none;">
        <div class="modal-box">

            <div class="modal-header">
                <div class="modal-header-icon" style="background:linear-gradient(135deg,#0369a1,#0284c7);">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <div class="modal-header-text">
                    <div class="modal-title">Edit Pengguna</div>
                    <div class="modal-subtitle" id="editModalSub">Perbarui data pengguna</div>
                </div>
                <button class="modal-close" type="button" onclick="tutupModal('modalEdit')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" id="formEdit" action="">
                @csrf
                <div class="modal-body">

                    <p class="form-section-label"><i class="fa-solid fa-id-card"></i> Informasi Dasar</p>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap <span style="color:#DC2626">*</span></label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="nama" id="editNama" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" name="no_telp" id="editNoTelp">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>NIK</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-id-badge"></i>
                                <input type="text" name="nik" id="editNik" maxlength="16">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-calendar"></i>
                                <input type="date" name="tanggal_lahir" id="editTanggalLahir">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="editJenisKelamin">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" name="alamat" id="editAlamat">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Email <span style="color:#DC2626">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" id="editEmail" required>
                        </div>
                    </div>

                    {{-- Field khusus Dokter --}}
                    <div id="edit-field-dokter" style="display:none;">
                        <p class="form-section-label"><i class="fa-solid fa-stethoscope"></i> Data Dokter</p>
                        <div class="form-group">
                            <label>Spesialis</label>
                            <div class="input-with-icon">
                                <i class="fa-solid fa-stethoscope"></i>
                                <input type="text" name="spesialis" id="editSpesialis">
                            </div>
                        </div>
                    </div>

                    {{-- Field khusus Pasien --}}
                    <div id="edit-field-pasien" style="display:none;">
                        <p class="form-section-label"><i class="fa-solid fa-notes-medical"></i> Data Pasien</p>
                        <div class="form-row">
                            <div class="form-group">
                                <label>No. BPJS</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-id-card"></i>
                                    <input type="text" name="no_bpjs" id="editNoBpjs" maxlength="13">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Riwayat Penyakit</label>
                                <div class="input-with-icon">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                    <input type="text" name="riwayat_penyakit" id="editRiwayat">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn-modal-cancel" type="button" onclick="tutupModal('modalEdit')">
                        <i class="fa-solid fa-xmark" style="margin-right:5px"></i>Batal
                    </button>
                    <button class="btn-modal-save" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

{{-- Data user untuk modal edit (JSON tersembunyi) --}}
<script>
    const USERS_DATA = @json($users->keyBy('id_user')->map(function($u) {
        return [
            'id_user'          => $u->id_user,
            'nama'             => $u->nama,
            'email'            => $u->email,
            'no_telp'          => $u->no_telp,
            'nik'              => $u->nik,
            'tanggal_lahir'    => $u->tanggal_lahir?->format('Y-m-d'),
            'jenis_kelamin'    => $u->jenis_kelamin,
            'alamat'           => $u->alamat,
            'role'             => $u->role,
            'spesialis'        => $u->dokter?->spesialis,
            'no_bpjs'          => $u->pasien?->no_bpjs,
            'riwayat_penyakit' => $u->pasien?->riwayat_penyakit,
        ];
    }));

    const ROUTE_UPDATE_BASE = "{{ url('/admin/kelolaAkunPengguna') }}";
</script>

@endsection

@push('scripts')
<script>
// ── Buka / Tutup Modal ───────────────────────────────────
function tutupModal(id) {
    document.getElementById(id).style.display = 'none';
}
function bukaModal(id) {
    document.getElementById(id).style.display = 'flex';
}

// Tutup modal klik overlay
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
        if (e.target === overlay) overlay.style.display = 'none';
    });
});

// ── Tombol Tambah ────────────────────────────────────────
document.getElementById('btnAddUser').addEventListener('click', () => {
    bukaModal('modalTambah');
});

// Buka modal tambah jika ada error validasi (redirect back)
@if ($errors->any() && old('_intended') !== 'edit')
    bukaModal('modalTambah');
@endif

// ── Toggle field role (tambah) ───────────────────────────
function toggleFieldRole(role, prefix) {
    const dokterField = document.getElementById(prefix + '-field-dokter');
    const pasienField = document.getElementById(prefix + '-field-pasien');
    if (dokterField) dokterField.style.display = role === 'Dokter'  ? 'block' : 'none';
    if (pasienField) pasienField.style.display = role === 'Pasien'  ? 'block' : 'none';
}

// Init saat halaman load (jika ada old value)
toggleFieldRole('{{ old('role', '') }}', 'tambah');

// ── Toggle password ──────────────────────────────────────
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// ── Buka Modal Edit ──────────────────────────────────────
function bukaModalEdit(idUser) {
    const user = USERS_DATA[idUser];
    if (!user) return;

    // Isi form
    document.getElementById('editNama').value          = user.nama          ?? '';
    document.getElementById('editEmail').value         = user.email         ?? '';
    document.getElementById('editNoTelp').value        = user.no_telp       ?? '';
    document.getElementById('editNik').value           = user.nik           ?? '';
    document.getElementById('editTanggalLahir').value  = user.tanggal_lahir ?? '';
    document.getElementById('editAlamat').value        = user.alamat        ?? '';

    // Jenis kelamin
    const selJK = document.getElementById('editJenisKelamin');
    selJK.value = user.jenis_kelamin ?? '';

    // Field role-spesifik
    const dokterDiv = document.getElementById('edit-field-dokter');
    const pasienDiv = document.getElementById('edit-field-pasien');
    dokterDiv.style.display = user.role === 'Dokter'  ? 'block' : 'none';
    pasienDiv.style.display = user.role === 'Pasien'  ? 'block' : 'none';

    if (user.role === 'Dokter') {
        document.getElementById('editSpesialis').value = user.spesialis ?? '';
    }
    if (user.role === 'Pasien') {
        document.getElementById('editNoBpjs').value  = user.no_bpjs          ?? '';
        document.getElementById('editRiwayat').value = user.riwayat_penyakit ?? '';
    }

    // Subtitle
    document.getElementById('editModalSub').textContent = `Edit akun: ${user.nama} (${user.role})`;

    // Set action form
    document.getElementById('formEdit').action = `${ROUTE_UPDATE_BASE}/${idUser}`;

    bukaModal('modalEdit');
}
</script>
<script src="{{ asset('js/kelolaAkunPengguna.js') }}"></script>
@endpush
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92

/**
 * manageUsers.js
 * Fitur: Search live, Filter Role & Status, Pagination, View Detail,
 *        Edit, Tambah, Toggle Status, Hapus — dropdown "Lebih Lanjut" fixed position
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ================================================
       DATA (simulasi — ganti dengan AJAX ke backend)
    ================================================ */
    let users = [
        { id:'USR-2026-001', name:'Dr. Reza Pratama',   initials:'DR', email:'reza@sicksafe.com',     role:'dokter',   phone:'+62 812-3456-7890', created:'15 Jan 2026', status:'aktif'    },
        { id:'USR-2026-002', name:'Aprina Santoso',     initials:'AP', email:'aprina@sicksafe.com',   role:'apoteker', phone:'+62 812-9876-5432', created:'20 Jan 2026', status:'aktif'    },
        { id:'USR-2026-003', name:'Siti Indriyani',     initials:'SI', email:'siti@sicksafe.com',     role:'admin',    phone:'+62 812-1111-2222', created:'10 Feb 2026', status:'aktif'    },
        { id:'USR-2026-004', name:'Budi Wijaya',        initials:'BW', email:'budi@sicksafe.com',     role:'dokter',   phone:'+62 812-3333-4444', created:'25 Feb 2026', status:'nonaktif' },
        { id:'USR-2026-005', name:'Nurul Putri',        initials:'NP', email:'nurul@sicksafe.com',    role:'apoteker', phone:'+62 812-5555-6666', created:'01 Mar 2026', status:'aktif'    },
        { id:'USR-2026-006', name:'Ahmad Fauzi',        initials:'AF', email:'ahmad@sicksafe.com',    role:'dokter',   phone:'+62 813-1111-0001', created:'03 Mar 2026', status:'aktif'    },
        { id:'USR-2026-007', name:'Dewi Rahayu',        initials:'DR', email:'dewi@sicksafe.com',     role:'apoteker', phone:'+62 813-1111-0002', created:'05 Mar 2026', status:'nonaktif' },
        { id:'USR-2026-008', name:'Hendra Gunawan',     initials:'HG', email:'hendra@sicksafe.com',   role:'admin',    phone:'+62 813-1111-0003', created:'07 Mar 2026', status:'aktif'    },
        { id:'USR-2026-009', name:'Ika Lestari',        initials:'IL', email:'ika@sicksafe.com',      role:'dokter',   phone:'+62 813-1111-0004', created:'09 Mar 2026', status:'aktif'    },
        { id:'USR-2026-010', name:'Joko Santoso',       initials:'JS', email:'joko@sicksafe.com',     role:'apoteker', phone:'+62 813-1111-0005', created:'11 Mar 2026', status:'aktif'    },
        { id:'USR-2026-011', name:'Kartika Wulandari',  initials:'KW', email:'kartika@sicksafe.com',  role:'dokter',   phone:'+62 813-1111-0006', created:'13 Mar 2026', status:'nonaktif' },
        { id:'USR-2026-012', name:'Lukman Hakim',       initials:'LH', email:'lukman@sicksafe.com',   role:'admin',    phone:'+62 813-1111-0007', created:'15 Mar 2026', status:'aktif'    },
    ];

    /* ================================================
       STATE
    ================================================ */
    let currentPage  = 1;
    const perPage    = 5;
    let filterRole   = '';
    let filterStatus = '';
    let searchQuery  = '';
    let editingId    = null;

    /* ================================================
       DOM REFS
    ================================================ */
    const tbody          = document.getElementById('usersTableBody');
    const searchInput    = document.getElementById('searchInput');
    const selectRole     = document.getElementById('filterRole');
    const selectStatus   = document.getElementById('filterStatus');
    const checkAll       = document.getElementById('checkAll');
    const paginationEl   = document.getElementById('pagination');
    const paginationInfo = document.getElementById('paginationInfo');

    const modalAddEdit       = document.getElementById('modalAddEdit');
    const modalAddEditTitle  = document.getElementById('modalAddEditTitle');
    const modalAddEditSub    = document.getElementById('modalAddEditSub');
    const modalAddEditIcon   = document.getElementById('modalAddEditIcon');
    const inputName          = document.getElementById('inputName');
    const inputEmail         = document.getElementById('inputEmail');
    const inputPhone         = document.getElementById('inputPhone');
    const inputRole          = document.getElementById('inputRole');
    const inputStatus        = document.getElementById('inputStatus');
    const inputPassword      = document.getElementById('inputPassword');
    const btnPwdToggle       = document.getElementById('btnPwdToggle');

    const modalDetail = document.getElementById('modalDetail');
    const modalConfirm  = document.getElementById('modalConfirm');
    const confirmMsg    = document.getElementById('confirmMsg');
    const btnConfirmOk  = document.getElementById('btnConfirmOk');
    let   confirmAction = null;

    /* ================================================
       DROPDOWN (lebih lanjut) — satu shared element
    ================================================ */
    let activeDropdownId = null;
    const dropdown = document.createElement('div');
    dropdown.className = 'dropdown-menu';
    dropdown.id = 'sharedDropdown';
    dropdown.innerHTML = `
        <button class="dropdown-item item-toggle" data-dd="toggle">
            <i class="fa-solid fa-power-off"></i> Toggle Status
        </button>
        <button class="dropdown-item item-edit" data-dd="edit">
            <i class="fa-solid fa-pen"></i> Edit Pengguna
        </button>
        <button class="dropdown-item item-delete" data-dd="delete">
            <i class="fa-solid fa-trash"></i> Hapus Akun
        </button>
    `;
    document.body.appendChild(dropdown);

    function openDropdown(btn, userId) {
        // Tutup dulu kalau sama
        if (activeDropdownId === userId && dropdown.classList.contains('open')) {
            closeDropdown(); return;
        }
        activeDropdownId = userId;

        const rect = btn.getBoundingClientRect();
        dropdown.style.top  = (rect.bottom + 6) + 'px';

        // Cek apakah cukup ruang di kanan
        const menuW = 190;
        if (rect.right + menuW > window.innerWidth) {
            dropdown.style.left = (rect.right - menuW) + 'px';
        } else {
            dropdown.style.left = rect.left + 'px';
        }

        dropdown.classList.add('open');
        btn.classList.add('open');
    }

    function closeDropdown() {
        dropdown.classList.remove('open');
        activeDropdownId = null;
        document.querySelectorAll('.btn-more.open').forEach(b => b.classList.remove('open'));
    }

    // Klik di luar dropdown → tutup
    document.addEventListener('click', e => {
        if (!dropdown.contains(e.target) && !e.target.closest('.btn-more')) {
            closeDropdown();
        }
    });

    // Scroll window → reposisi atau tutup
    window.addEventListener('scroll', () => { closeDropdown(); }, true);

    // Klik item dropdown
    dropdown.addEventListener('click', e => {
        const item = e.target.closest('[data-dd]');
        if (!item || !activeDropdownId) return;
        const action = item.dataset.dd;
        const user   = users.find(u => u.id === activeDropdownId);
        closeDropdown();
        if (!user) return;
        if (action === 'toggle') confirmToggle(user);
        if (action === 'edit')   openEditModal(user);
        if (action === 'delete') confirmDelete(user);
    });

    /* ================================================
       HELPERS
    ================================================ */
    function normalize(str) { return str.toLowerCase().replace(/\s+/g,' ').trim(); }

    function getFiltered() {
        const q = normalize(searchQuery);
        return users.filter(u => {
            const matchSearch = !q ||
                normalize(u.name).includes(q) ||
                normalize(u.email).includes(q) ||
                normalize(u.id).includes(q);
            const matchRole   = !filterRole   || u.role   === filterRole;
            const matchStatus = !filterStatus || u.status === filterStatus;
            return matchSearch && matchRole && matchStatus;
        });
    }

    function roleBadge(role) {
        const map = { dokter:['role-dokter','Dokter'], apoteker:['role-apoteker','Apoteker'], admin:['role-admin','Admin'] };
        const [cls, label] = map[role] || ['role-admin', role];
        return `<span class="role-badge ${cls}">${label}</span>`;
    }

    function statusBadge(status) {
        return status === 'aktif'
            ? `<span class="status-badge status-aktif"><i class="fa-solid fa-circle-check" style="font-size:9px"></i> Aktif</span>`
            : `<span class="status-badge status-nonaktif"><i class="fa-solid fa-circle-xmark" style="font-size:9px"></i> Non-Aktif</span>`;
    }

    function getInitials(name) {
        return name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
    }

    function formatDate(d) {
        return d.toLocaleDateString('id-ID',{ day:'2-digit', month:'short', year:'numeric' });
    }

    function openModal(el)  { el.classList.add('active'); document.body.style.overflow='hidden'; }
    function closeModal(el) { el?.classList.remove('active'); document.body.style.overflow=''; }

    function showToast(message, type='success') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        const icons = { success:'<i class="fa-solid fa-check"></i>', error:'<i class="fa-solid fa-xmark"></i>', warning:'<i class="fa-solid fa-triangle-exclamation"></i>' };
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `${icons[type] || '•'} ${message}`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    /* ================================================
       RENDER TABEL
    ================================================ */
    function renderTable() {
        const filtered = getFiltered();
        const total    = filtered.length;
        const pages    = Math.max(1, Math.ceil(total / perPage));
        if (currentPage > pages) currentPage = pages;
        const start   = (currentPage - 1) * perPage;
        const slice   = filtered.slice(start, start + perPage);
        const startNo = total === 0 ? 0 : start + 1;
        const endNo   = Math.min(start + perPage, total);

        paginationInfo.innerHTML = `Menampilkan <strong>${startNo}–${endNo}</strong> dari <strong>${total}</strong> pengguna`;

        if (slice.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="8">
                    <div class="empty-state">
                        <i class="fa-solid fa-users-slash"></i>
                        Tidak ada pengguna yang sesuai filter.
                    </div>
                </td></tr>`;
        } else {
            tbody.innerHTML = slice.map(u => `
                <tr data-id="${u.id}">
                    <td><input type="checkbox" class="check-row"></td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">${u.initials}</div>
                            <div class="user-info">
                                <div class="user-name">${u.name}</div>
                                <div class="user-id">ID: ${u.id}</div>
                            </div>
                        </div>
                    </td>
                    <td><a href="mailto:${u.email}" class="email-link">${u.email}</a></td>
                    <td>${roleBadge(u.role)}</td>
                    <td>${u.phone}</td>
                    <td>${u.created}</td>
                    <td>${statusBadge(u.status)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" title="Lihat Detail" data-action="view" data-id="${u.id}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-action btn-more" title="Lebih Lanjut" data-action="more" data-id="${u.id}">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        renderPagination(pages);
        checkAll.checked = false;
    }

    /* ================================================
       PAGINATION
    ================================================ */
    function renderPagination(pages) {
        const range = 2;
        let start = Math.max(1, currentPage - range);
        let end   = Math.min(pages, currentPage + range);
        let html  = `<button class="page-btn" id="btnPrev" ${currentPage===1?'disabled':''}><i class="fa-solid fa-chevron-left"></i></button>`;
        if (start > 1) html += `<button class="page-btn" data-page="1">1</button>${start>2?'<span style="padding:0 4px;color:var(--text-muted)">…</span>':''}`;
        for (let i = start; i <= end; i++)
            html += `<button class="page-btn ${i===currentPage?'active':''}" data-page="${i}">${i}</button>`;
        if (end < pages) html += `${end<pages-1?'<span style="padding:0 4px;color:var(--text-muted)">…</span>':''}<button class="page-btn" data-page="${pages}">${pages}</button>`;
        html += `<button class="page-btn" id="btnNext" ${currentPage===pages?'disabled':''}><i class="fa-solid fa-chevron-right"></i></button>`;
        paginationEl.innerHTML = html;

        document.getElementById('btnPrev')?.addEventListener('click', () => { currentPage--; renderTable(); });
        document.getElementById('btnNext')?.addEventListener('click', () => { currentPage++; renderTable(); });
        paginationEl.querySelectorAll('.page-btn[data-page]').forEach(btn =>
            btn.addEventListener('click', () => { currentPage = parseInt(btn.dataset.page); renderTable(); })
        );
    }

    /* ================================================
       FILTER & SEARCH
    ================================================ */
    searchInput.addEventListener('input', () => { searchQuery = searchInput.value; currentPage=1; renderTable(); });
    selectRole.addEventListener('change',  () => { filterRole   = selectRole.value;  currentPage=1; renderTable(); });
    selectStatus.addEventListener('change',() => { filterStatus = selectStatus.value;currentPage=1; renderTable(); });

    /* ================================================
       SELECT ALL
    ================================================ */
    checkAll.addEventListener('change', () => {
        tbody.querySelectorAll('.check-row').forEach(cb => { cb.checked = checkAll.checked; });
    });

    /* ================================================
       ACTION BUTTONS (delegasi)
    ================================================ */
    tbody.addEventListener('click', e => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const action = btn.dataset.action;
        const id     = btn.dataset.id;
        const user   = users.find(u => u.id === id);

        if (action === 'view' && user) { openDetailModal(user); return; }
        if (action === 'more') { openDropdown(btn, id); return; }
    });

    /* ================================================
       MODAL: TAMBAH
    ================================================ */
    document.getElementById('btnAddUser')?.addEventListener('click', openAddModal);
    document.getElementById('btnAddUserTopbar')?.addEventListener('click', openAddModal);

    function openAddModal() {
        editingId = null;
        modalAddEditTitle.textContent = 'Tambah Pengguna Baru';
        modalAddEditSub.textContent   = 'Isi data pengguna dengan lengkap';
        modalAddEditIcon.innerHTML    = '<i class="fa-solid fa-user-plus"></i>';
        inputName.value = inputEmail.value = inputPhone.value = inputPassword.value = '';
        inputRole.value = ''; inputStatus.value = 'aktif';
        document.getElementById('passwordGroup').style.display = '';
        openModal(modalAddEdit);
        setTimeout(() => inputName.focus(), 100);
    }

    /* ================================================
       MODAL: EDIT
    ================================================ */
    function openEditModal(user) {
        editingId = user.id;
        modalAddEditTitle.textContent = 'Edit Pengguna';
        modalAddEditSub.textContent   = `Mengedit data: ${user.name}`;
        modalAddEditIcon.innerHTML    = '<i class="fa-solid fa-pen-to-square"></i>';
        inputName.value   = user.name;
        inputEmail.value  = user.email;
        inputPhone.value  = user.phone;
        inputRole.value   = user.role;
        inputStatus.value = user.status;
        inputPassword.value = '';
        document.getElementById('passwordGroup').style.display = 'none';
        openModal(modalAddEdit);
    }

    /* ================================================
       SIMPAN FORM
    ================================================ */
    document.getElementById('btnSaveUser').addEventListener('click', () => {
        const name   = inputName.value.trim();
        const email  = inputEmail.value.trim();
        const phone  = inputPhone.value.trim();
        const role   = inputRole.value;
        const status = inputStatus.value;

        if (!name || !email || !role) {
            showToast('Nama, email, dan role wajib diisi.', 'error'); return;
        }
        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRe.test(email)) {
            showToast('Format email tidak valid.', 'error'); return;
        }

        if (editingId) {
            const idx = users.findIndex(u => u.id === editingId);
            if (idx !== -1) {
                users[idx] = { ...users[idx], name, email, phone, role, status, initials: getInitials(name) };
                showToast(`Pengguna "${name}" berhasil diperbarui.`, 'success');
            }
        } else {
            const newId = 'USR-' + new Date().getFullYear() + '-' + String(users.length+1).padStart(3,'0');
            users.push({ id:newId, name, email, phone, role, status, initials:getInitials(name), created:formatDate(new Date()) });
            showToast(`Pengguna "${name}" berhasil ditambahkan.`, 'success');
        }

        closeModal(modalAddEdit);
        renderTable();
    });

    /* ================================================
       MODAL: DETAIL
    ================================================ */
    function openDetailModal(user) {
        document.getElementById('detailAvatarLg').textContent   = user.initials;
        document.getElementById('detailMainName').textContent   = user.name;
        document.getElementById('detailMainId').textContent     = 'ID: ' + user.id;
        document.getElementById('detailEmail').textContent      = user.email;
        document.getElementById('detailPhone').textContent      = user.phone;
        document.getElementById('detailRole').innerHTML         = roleBadge(user.role);
        document.getElementById('detailStatus').innerHTML       = statusBadge(user.status);
        document.getElementById('detailCreated').textContent    = user.created;
        openModal(modalDetail);
    }

    /* ================================================
       TOGGLE STATUS
    ================================================ */
    function confirmToggle(user) {
        const next = user.status === 'aktif' ? 'Non-Aktif' : 'Aktif';
        confirmMsg.innerHTML = `Ubah status <strong>${user.name}</strong> menjadi <strong>${next}</strong>?`;
        document.getElementById('confirmIcon').textContent = '⚡';
        confirmAction = () => {
            user.status = user.status === 'aktif' ? 'nonaktif' : 'aktif';
            showToast(`Status "${user.name}" → ${next}.`, 'success');
            renderTable();
        };
        openModal(modalConfirm);
    }

    /* ================================================
       HAPUS PENGGUNA
    ================================================ */
    function confirmDelete(user) {
        confirmMsg.innerHTML = `Hapus akun <strong>${user.name}</strong>?<br><small style="color:var(--text-muted)">Tindakan ini tidak dapat dibatalkan.</small>`;
        document.getElementById('confirmIcon').textContent = '🗑️';
        confirmAction = () => {
            users = users.filter(u => u.id !== user.id);
            showToast(`Akun "${user.name}" telah dihapus.`, 'warning');
            renderTable();
        };
        openModal(modalConfirm);
    }

    btnConfirmOk.addEventListener('click', () => {
        if (typeof confirmAction === 'function') confirmAction();
        closeModal(modalConfirm);
        confirmAction = null;
    });

    /* ================================================
       CLOSE MODALS
    ================================================ */
    document.querySelectorAll('.modal-close, .btn-modal-cancel').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal-overlay')));
    });
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(overlay); });
    });

    /* ================================================
       PASSWORD TOGGLE
    ================================================ */
    btnPwdToggle?.addEventListener('click', () => {
        const isText = inputPassword.type === 'text';
        inputPassword.type = isText ? 'password' : 'text';
        btnPwdToggle.querySelector('i').className = isText ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
    });

    /* ================================================
       INIT
    ================================================ */
    renderTable();
});
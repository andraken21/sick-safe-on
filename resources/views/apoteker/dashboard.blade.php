@extends('layouts.app')

@section('title', 'Dashboard Apoteker - Sick Safe ON')

@push('styles')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --purple-dark: #4A2C8F;
        --purple-mid: #5E35B1;
        --purple-light: #7B52C8;
        --orange: #F97316;
        --white: #ffffff;
        --gray-50: #F8F9FA;
        --gray-100: #F1F3F5;
        --gray-200: #E9ECEF;
        --gray-400: #ADB5BD;
        --gray-600: #6C757D;
        --gray-800: #343A40;
        --text: #1E1E2F;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #EDECF5;
    }

    .dashboard-wrapper {
        width: 100%;
        min-height: 100vh;
        padding: 24px;
    }

    .dashboard-card {
        width: 100%;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        min-height: 85vh;
        box-shadow: 0 8px 40px rgba(94,53,177,0.10);
    }

    /* SIDEBAR */
    .sidebar {
        width: 240px;
        background: linear-gradient(180deg, #4A2C8F 0%, #3D1F85 100%);
        color: white;
        flex-shrink: 0;
    }

    .sidebar-header {
        padding: 24px;
        font-size: 20px;
        font-weight: bold;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .nav-menu {
        padding: 16px 0;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 24px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: .2s;
    }

    .nav-item:hover,
    .nav-item.active {
        background: rgba(255,255,255,0.1);
        color: white;
    }

    /* MAIN */
    .main-content {
        flex: 1;
        padding: 32px;
        overflow-x: auto;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    /* TABS */
    .tabs {
        display: flex;
        border-bottom: 1px solid var(--gray-200);
        margin-bottom: 24px;
        overflow-x: auto;
    }

    .tab {
        padding: 12px 20px;
        cursor: pointer;
        font-weight: 600;
        color: var(--gray-600);
        border-bottom: 3px solid transparent;
        white-space: nowrap;
    }

    .tab.active {
        color: var(--purple-mid);
        border-color: var(--purple-mid);
    }

    /* TABLE */
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    th {
        background: var(--gray-50);
        color: var(--gray-600);
        font-size: 14px;
    }

    tbody tr {
        transition: .2s;
        cursor: pointer;
    }

    tbody tr:hover {
        background: #f8f5ff;
    }

    tbody tr.selected {
        background: #F3EEFF;
    }

    /* DETAIL */
    .detail-section {
        margin-top: 32px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 24px;
    }

    .detail-item {
        margin-bottom: 12px;
        font-size: 14px;
    }

    .detail-item strong {
        color: var(--gray-600);
    }

    /* BUTTON */
    .actions {
        display: flex;
        gap: 16px;
        margin-top: 32px;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: .2s;
    }

    .btn-outline {
        background: #f1f3f5;
    }

    .btn-primary {
        background: var(--purple-mid);
        color: white;
    }

    .btn-dark {
        background: var(--purple-dark);
        color: white;
    }

    /* RESPONSIVE */
    @media(max-width: 992px) {
        .dashboard-card {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
<link rel="stylesheet" href="{{ asset('css/dashboardApoteker.css') }}">  

    {{-- MAIN AREA --}}
    <div class="dash-main">

        {{-- CONTENT --}}
        <div class="dash-content">
            ISI DASHBOARD NYA LETAK SINI
        </div>
        {{-- /CONTENT --}}

    </div>
    {{-- /MAIN AREA --}}
<script src="{{ asset('js/dashboardApoteker.js') }}"></script>
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
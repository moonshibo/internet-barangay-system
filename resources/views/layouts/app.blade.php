<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Internet Barangay System')</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

<div class="app-container">

<!-- TOP BLUE HEADER -->
<header class="top-header">

    <div class="system-brand">
        <div class="brand-logo">
            IB
        </div>

        <div class="brand-name">
            <strong>IntRENet</strong>
            <span>Internet Barangay System</span>
        </div>
    </div>

    <div class="header-title">
        @yield('page-title', 'Dashboard')
    </div>

    <div class="header-profile">
        <div class="profile-avatar">
            U
        </div>

        <span>Profile</span>
    </div>

</header>


<!-- SIDEBAR -->
<aside class="sidebar">

    <nav class="sidebar-menu">

        @if (request()->is('personnel/*'))

            <!-- PERSONNEL SIDEBAR -->

            <a href="{{ url('/personnel/dashboard-preview') }}"
               class="sidebar-item {{ request()->is('personnel/dashboard-preview') ? 'active' : '' }}">

                <span class="sidebar-icon">⌂</span>
                <span>Dashboard</span>

            </a>


            <a href="{{ url('/personnel/requests') }}"
               class="sidebar-item {{ request()->is('personnel/requests*') ? 'active' : '' }}">

                <span class="sidebar-icon">▤</span>
                <span>Manage Requests</span>

            </a>


            <a href="{{ url('/personnel/reports') }}"
               class="sidebar-item {{ request()->is('personnel/reports') ? 'active' : '' }}">

                <span class="sidebar-icon">▥</span>
                <span>Reports</span>

            </a>


        @else

            <!-- CITIZEN SIDEBAR -->

            <a href="{{ url('/citizen/dashboard-preview') }}"
               class="sidebar-item {{ request()->is('citizen/dashboard-preview') ? 'active' : '' }}">

                <span class="sidebar-icon">⌂</span>
                <span>Home</span>

            </a>


            <a href="{{ url('/citizen/submit-request') }}"
               class="sidebar-item {{ request()->is('citizen/submit-request') ? 'active' : '' }}">

                <span class="sidebar-icon">▤</span>
                <span>Submit Concern</span>

            </a>


            <a href="{{ url('/citizen/track-request') }}"
               class="sidebar-item {{ request()->is('citizen/track-request') ? 'active' : '' }}">

                <span class="sidebar-icon">☷</span>
                <span>Track Request</span>

            </a>


            <a href="{{ url('/citizen/history') }}"
               class="sidebar-item {{ request()->is('citizen/history') ? 'active' : '' }}">

                <span class="sidebar-icon">◷</span>
                <span>History</span>

            </a>

        @endif

    </nav>


    <!-- LOGOUT -->

    <div class="sidebar-bottom">

        <button type="button"
                class="sidebar-item logout-button"
                id="logoutButton">

            <span class="sidebar-icon">↪</span>
            <span>Log Out</span>

        </button>

    </div>

</aside>


<!-- MAIN CONTENT -->

<main class="main-content">

    <section class="page-content">

        @yield('content')

    </section>

</main>

</div>

<!-- LOGOUT MODAL -->

<div class="modal-overlay" id="logoutModal">

<div class="logout-modal">

    <button
        type="button"
        class="modal-close"
        id="closeLogoutModal">
        ×
    </button>

    <div class="modal-icon">
        ↪
    </div>

    <h2>Log Out?</h2>

    <p>
        Are you sure you want to log out?
    </p>

    <div class="modal-buttons">

        <button
            type="button"
            class="cancel-button"
            id="cancelLogout">
            Cancel
        </button>

        <button
            type="button"
            class="confirm-button">
            Log Out
        </button>

    </div>

</div>

</div>

@stack('scripts')

</body>
</html>

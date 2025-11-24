{{-- resources/views/partials/header.blade.php --}}

<style>
/* ===========================
   MODERN PROFILE DROPDOWN
   =========================== */

.profile-dropdown-container {
    position: relative;
}

/* PROFILE TRIGGER BUTTON */
.profile-trigger {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #ff6b6b 0%, #ff9a8b 100%);
    padding: 0.45rem 1.2rem;
    border-radius: 999px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    box-shadow: 0 4px 16px rgba(255, 107, 107, 0.45);
}

.profile-trigger:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 26px rgba(255, 107, 107, 0.55);
}

.profile-trigger:active {
    transform: translateY(0);
}

.profile-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid #ffffff;
    object-fit: cover;
    transition: transform 0.25s ease;
    background: #fff;
}

.profile-trigger:hover .profile-avatar {
    transform: scale(1.05);
}

.profile-name {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
    letter-spacing: 0.01em;
    white-space: nowrap;
}

.dropdown-arrow {
    color: #ffffff;
    font-size: 0.75rem;
    transition: transform 0.25s ease;
}

.profile-trigger.active .dropdown-arrow {
    transform: rotate(180deg);
}

/* DROPDOWN MENU */
.profile-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: #ffffff;
    border-radius: 20px;
    min-width: 260px;
    box-shadow: 0 20px 55px rgba(15, 23, 42, 0.25);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px) scale(0.97);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 999;
    overflow: hidden;
}

.profile-dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* DROPDOWN HEADER */
.dropdown-header {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff9a8b 50%, #ffd1c1 100%);
    padding: 1.3rem 1.4rem 1.4rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.dropdown-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.16) 0%, transparent 70%);
    animation: shimmer 3s linear infinite;
}

@keyframes shimmer {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.dropdown-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    border: 4px solid #ffffff;
    object-fit: cover;
    margin: 0 auto 0.6rem;
    display: block;
    position: relative;
    z-index: 1;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    background: #fff;
}

.dropdown-user-name {
    color: #ffffff;
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 0.15rem;
    position: relative;
    z-index: 1;
}

.dropdown-user-meta {
    color: rgba(255,255,255,0.9);
    font-size: 0.8rem;
    position: relative;
    z-index: 1;
}

/* DROPDOWN BODY */
.dropdown-body {
    padding: 0.5rem 0.5rem 0.6rem;
}

.dropdown-item-modern {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.75rem 0.9rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    color: #374151;
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
}

.dropdown-item-modern::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, rgba(255, 107, 107, 0.12), rgba(255, 148, 114, 0.12));
    transition: width 0.25s ease;
}

.dropdown-item-modern:hover {
    background: rgba(248,250,252,0.9);
    transform: translateX(3px);
}

.dropdown-item-modern:hover::before {
    width: 100%;
}

.dropdown-item-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    position: relative;
    z-index: 1;
    color: #ffffff;
}

.dropdown-item-icon.profile {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff9a8b 100%);
}

.dropdown-item-icon.logout {
    background: linear-gradient(135deg, #f97373 0%, #fbbf77 100%);
}

.dropdown-item-text {
    flex: 1;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.dropdown-item-arrow {
    font-size: 0.75rem;
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.2s ease;
    position: relative;
    z-index: 1;
}

.dropdown-item-modern:hover .dropdown-item-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* DIVIDER */
.dropdown-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    margin: 0.4rem 0;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .profile-name {
        display: none;
    }
}
</style>

<header>
    {{-- LOGO --}}
    <img src="{{ asset('images/LOGOGALLERY.png') }}" class="logo" alt="GallerySI Logo">

    <nav>
        {{-- NAV LINKS KIRI --}}
        <ul class="nav-links">
            <li class="nav-item {{ Request::is('eksplorasi', '/eksplorasi*') ? 'active' : '' }}">
                <a href="{{ route('eksplorasi.index') }}">Eksplorasi</a>
            </li>

            @auth
                @php
                    $countNotif = \App\Models\Like::whereHas('artwork', fn($q) => $q->where('user_id', Auth::id()))->count()
                                + \App\Models\Comment::whereHas('artwork', fn($q) => $q->where('user_id', Auth::id()))->count();
                @endphp

                <li class="nav-item {{ Request::is('notifications') ? 'active' : '' }}">
                    <a href="{{ route('notifications.index') }}">
                        Notifikasi ({{ $countNotif }})
                    </a>
                </li>
            @endauth
        </ul>

        {{-- AUTH AREA KANAN --}}
        <div class="auth">
            @guest
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            @else
                {{-- MODERN PROFILE DROPDOWN --}}
                <div class="profile-dropdown-container">
                    {{-- TRIGGER --}}
                    <button class="profile-trigger" id="profileTrigger">
                        @if (auth()->user()->image)
                            <img src="{{ asset('storage/user/' . auth()->user()->image) }}"
                                 alt="Profile" class="profile-avatar">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}"
                                 alt="Profile" class="profile-avatar">
                        @endif
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                        <span class="dropdown-arrow">▼</span>
                    </button>

                    {{-- DROPDOWN MENU --}}
                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        {{-- HEADER --}}
                        <div class="dropdown-header">
                            @if (auth()->user()->image)
                                <img src="{{ asset('storage/user/' . auth()->user()->image) }}"
                                     alt="Profile" class="dropdown-avatar">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}"
                                     alt="Profile" class="dropdown-avatar">
                            @endif

                            <div class="dropdown-user-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-user-meta">
                                {{ auth()->user()->email ?? 'GallerySI Member' }}
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="dropdown-body">
                            <a href="{{ route('profile.index') }}" class="dropdown-item-modern">
                                <div class="dropdown-item-icon profile">
                                    👤
                                </div>
                                <span class="dropdown-item-text">Profil</span>
                                <span class="dropdown-item-arrow">→</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="{{ route('logout') }}"
                               class="dropdown-item-modern"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="dropdown-item-icon logout">
                                    🚪
                                </div>
                                <span class="dropdown-item-text">Keluar</span>
                                <span class="dropdown-item-arrow">→</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- LOGOUT FORM --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('profileTrigger');
    const menu    = document.getElementById('profileDropdownMenu');

    if (!trigger || !menu) return;

    // toggle dropdown
    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        trigger.classList.toggle('active');
        menu.classList.toggle('active');
    });

    // close when click outside
    document.addEventListener('click', function (e) {
        if (!trigger.contains(e.target) && !menu.contains(e.target)) {
            trigger.classList.remove('active');
            menu.classList.remove('active');
        }
    });

    // stop bubbling inside menu
    menu.addEventListener('click', function (e) {
        e.stopPropagation();
    });
});
</script>

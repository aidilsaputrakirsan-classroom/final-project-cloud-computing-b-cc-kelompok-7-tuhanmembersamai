<header>
    <img src=" alt="logo" class="logo">
    <nav>
        <ul class="nav-links">
            <li class="nav-item {{ Request::is('/', '/*') ? 'active' : '' }}"><a href="/">Home</a></li>
            <li class="nav-item {{ Request::is('eksplorasi', '/eksplorasi*') ? 'active' : '' }}"><a
                    href="{{ route('eksplorasi.index') }}">Eksplorasi</a></li>
            <li class="nav-item"><a href="#aboutme">Tentang Kami</a></li>
        </ul>
        <div class="auth">
            @guest
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            @else
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        @if (auth()->user()->image)
                            <img src="{{ asset('storage/user/' . auth()->user()->image) }}" alt="Default" width="50px"
                                height="50px" style="border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Default" width="50px"
                                style="border-radius: 50%">
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <div class="profile">
                            @if (auth()->user()->image)
                                <img src="{{ asset('storage/user/' . auth()->user()->image) }}" alt="Default"
                                    width="50px" height="50px" style="border-radius: 50%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Default" width="50px"
                                    style="border-radius: 50%">
                            @endif
                            <h6>{{ auth()->user()->name }}</h6>
                        </div>
                        <div class="menu mt-2">
                            <a href="{{ route('profile.index') }}">Profil</a>
                            <!-- <a href="#">Unggah Karya</a> -->
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </ul>
                </div>
            @endguest
        </div>
    </nav>
</header>

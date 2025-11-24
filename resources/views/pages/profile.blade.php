@extends('layouts.main')

@section('section')

<style>
:root {
    --page-bg-top: #fff7fb;
    --page-bg-bottom: #ffece5;

    --text-main: #111827;
    --text-muted: #7a8a99;

    --accent: #ff6b6b;
    --accent-soft: #ffe4e4;
    --accent-dark: #0b1120;

    --border-soft: #e5e7f0;
    --card-border: #e0e7ef;

    --radius-xl: 32px;
    --radius-lg: 26px;
    --radius-md: 18px;

    --shadow-soft: 0 18px 40px rgba(15, 23, 42, 0.08);
    --shadow-hover: 0 22px 55px rgba(15, 23, 42, 0.14);
}

/* PAGE WRAPPER – full section */
.profile-container {
    max-width: 75%;
    margin: 2.5rem auto 3.5rem;
    padding: 2.5rem 2.75rem;
    background: linear-gradient(135deg, var(--page-bg-top), var(--page-bg-bottom));
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-soft);
    position: relative;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* BACK BUTTON */
.profile-container .back {
    position: absolute;
    left: 1.8rem;
    top: 1.8rem;
    cursor: pointer;
    transition: transform .15s ease;
}

.profile-container .back:hover {
    transform: translateX(-3px);
}

/* LAYOUT: LEFT PROFILE + RIGHT CARD */
.profile-layout {
    display: grid;
    grid-template-columns: minmax(0, 40%) minmax(0, 60%);
    gap: 3rem;
    align-items: flex-start;
}

/* LEFT SIDE */
.profile-left {
    padding-left: 2.8rem; /* jarak dari tombol back */
}

/* PROFILE AVATAR */
.profile-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1.5rem;
}

.profile-info img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 7px solid #ffffff;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.25);
    background: #fff;
}

/* BIG NAME ala mockup */
.profile-info .detail h4 {
    margin: 0;
    font-size: clamp(2.8rem, 5vw, 3.7rem);
    font-weight: 800;
    letter-spacing: -0.07em;
    text-transform: lowercase;
    color: var(--accent-dark);
}

.profile-info .detail p {
    margin: .2rem 0 0;
    font-size: .9rem;
    color: var(--text-muted);
}

/* TAB BUTTONS */
.menu {
    margin-top: 1.7rem;
    display: flex;
    gap: .75rem;
}

.btn-menu {
    border-radius: 999px;
    padding: .55rem 1.6rem;
    font-size: .9rem;
    border: 1px solid #f1f2f7;
    background: #ffffff;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .16s ease-out;
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
}

.btn-menu:hover {
    background: #fdfdfd;
}

.btn-menu.active {
    background: #111827;
    color: #ffffff;
    border-color: #111827;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.35);
}

/* RIGHT SIDE – CARD WRAPPER */
.profile-right {
    position: relative;
}

/* MAIN CARD (karya / about) */
.profile-card {
    width: 100%;
    min-height: 280px;
    border-radius: var(--radius-lg);
    background: radial-gradient(circle at top left, #ffffff, #fdfdfd);
    box-shadow: var(--shadow-soft);
    border: 1px solid rgba(255, 255, 255, 0.8);
    padding: 2.2rem 2.4rem 1.8rem;
    position: relative;
}

/* CLOSE ICON MOCKUP */
.profile-card-close {
    position: absolute;
    right: 1.8rem;
    top: 1.6rem;
    width: 32px;
    height: 32px;
    border-radius: 999px;
    border: 1px solid #edf0f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #9ca3af;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 3rem 1rem 2rem;
    color: var(--text-muted);
}

.empty-state-icon {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    background: #f5f7fb;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.3rem;
    color: #9ca3af;
    font-size: 1.8rem;
}

.empty-state-title {
    font-weight: 600;
    font-size: 1.05rem;
    color: var(--text-main);
    margin-bottom: .25rem;
}

.empty-state-subtitle {
    font-size: .9rem;
    color: var(--text-muted);
}

/* CARD DIVIDER */
.profile-card-divider {
    height: 1px;
    width: 100%;
    background: #edf0f6;
    margin: 2.1rem 0 1.5rem;
}

/* CARD BOTTOM ACTIONS */
.profile-card-actions {
    display: flex;
    justify-content: flex-end;
    gap: .75rem;
}

/* BUTTON VARIANTS */
.btn-ghost-danger {
    border-radius: 999px;
    padding: .5rem 1.6rem;
    font-size: .87rem;
    border: none;
    background: #ffe4e4;
    color: #b91c1c;
    font-weight: 600;
    cursor: pointer;
}

.btn-solid-accent {
    border-radius: 999px;
    padding: .5rem 1.7rem;
    font-size: .87rem;
    border: none;
    background: var(--accent);
    color: #ffffff;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(255, 107, 107, 0.36);
}

/* GRID KARYA DI DALAM CARD */
.artwork-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.card-artwork {
    background: #ffffff;
    border-radius: var(--radius-md);
    border: 1px solid var(--card-border);
    box-shadow: var(--shadow-soft);
    padding: .55rem;
    overflow: hidden;
    transition: transform .16s ease-out, box-shadow .16s ease-out;
}

.card-artwork img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 14px;
}

.card-artwork:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
}

/* ABOUT ME CARD CONTENT - IMPROVED */
.about-me {
    display: none; /* default hidden, di-toggle JS */
}

.about-me .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.about-me .form-column {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.about-me .form-group {
    display: flex;
    flex-direction: column;
}

.about-me .form-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 0.4rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.about-me input,
.about-me textarea {
    width: 100%;
    border-radius: 12px;
    border: 1px solid var(--border-soft);
    padding: .75rem 1rem;
    font-size: .9rem;
    background: #ffffff;
    color: var(--text-main);
    line-height: 1.5;
    font-family: system-ui, -apple-system, sans-serif;
}

.about-me textarea {
    resize: vertical;
    min-height: 120px;
}

.about-me textarea.bio-field {
    min-height: 200px;
}

.about-me input[readonly],
.about-me textarea[readonly] {
    background: #f7fafc;
    color: var(--text-main);
}

.about-me input::placeholder,
.about-me textarea::placeholder {
    color: #9ca3af;
}

.about-me .action {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.about-me .social-links {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.8rem;
}

/* MODAL TABLE */
.table-striped > tbody > tr:nth-of-type(odd) {
    --bs-table-accent-bg: #f9fbff;
}

.table-striped img {
    border-radius: 8px;
}

.btn-delete {
    border-radius: 999px;
    border: none;
    padding: .3rem .9rem;
    font-size: .8rem;
    background: #fee2e2;
    color: #b91c1c;
    cursor: pointer;
}

.btn-delete:hover {
    background: #fca5a5;
    color: #7f1d1d;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .profile-layout {
        grid-template-columns: minmax(0, 1fr);
        gap: 2.4rem;
    }

    .profile-left {
        padding-left: 0;
    }

    .profile-info {
        align-items: center;
    }

    .menu {
        justify-content: center;
    }

    .about-me .form-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 576px) {
    .profile-container {
        max-width: 90%;
        padding: 2rem 1.6rem;
    }

    .profile-container .back {
        position: relative;
        left: 0;
        top: 0;
        margin-bottom: .5rem;
    }
}
</style>

<div class="profile-container">
    <a href="{{ route('exploration') }}">
        <img src="{{ asset('images/back.png') }}" alt="back" width="40px" class="back">
    </a>

    <div class="profile-layout">
        {{-- LEFT SIDE --}}
        <div class="profile-left">
            <div class="profile-info">
                @if ($profile->image)
                    <img src="{{ asset('storage/' . $profile->image) }}" alt="profile">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="profile">
                @endif
                <div class="detail">
                    <h4>{{ auth()->user()->name }}</h4>
                    @if(auth()->user()->address)
                        <p>{{ auth()->user()->address }}</p>
                    @endif
                </div>
            </div>

            <div class="menu">
                <button class="btn-menu active" id="btn-karya">Karya kamu</button>
                <button class="btn-menu" id="btn-tentang">Tentang kamu</button>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="profile-right">
            {{-- CARD: KARYA KAMU --}}
            <div class="profile-card my-artworks">
                <div class="profile-card-close">×</div>

                @include('partials.alert')

                @if ($artworks->count() > 0)
                    <div class="artwork-grid">
                        @foreach ($artworks as $artwork)
                            <div class="card-artwork">
                                {{-- artwork dari Supabase: pakai URL langsung --}}
                                <img src="{{ $artwork->image }}" alt="artwork">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fa fa-image"></i>
                        </div>
                        <div class="empty-state-title">Tidak Ada Karya</div>
                        <div class="empty-state-subtitle">
                            Unggah karya pertamamu sekarang!
                        </div>
                    </div>
                @endif

                <div class="profile-card-divider"></div>

                <div class="profile-card-actions">
                    {{-- tombol Hapus -> modal --}}
                    <button type="button" class="btn-ghost-danger" data-bs-toggle="modal"
                            data-bs-target="#modalListDelete">
                        Hapus
                    </button>

                    {{-- tombol Unggah (dropdown) --}}
                    <div class="dropdown">
                        <button class="btn-solid-accent dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                            Unggah
                        </button>
                        <ul class="dropdown-menu upload p-3" style="min-width: 320px;">
                            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="inputfile"
                                           aria-describedby="inputgroupfile" aria-label="Upload" name="image">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Tambahkan deskripsi</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select mt-1" aria-label="select-category"
                                            name="category_id" id="category">
                                        <option selected disabled>Tambahkan kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn-solid-accent">OK</button>
                                </div>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- CARD: TENTANG KAMU - IMPROVED LAYOUT --}}
            <div class="profile-card about-me">
                <div class="profile-card-close">×</div>

                <div class="form-grid">
                    {{-- COLUMN 1: Bio & Skills --}}
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" placeholder="Nama" name="name" id="name"
                                   readonly value="{{ $profile->name }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Biografi</label>
                            <textarea rows="8" placeholder="Ceritakan tentang diri Anda"
                                      name="bio" id="bio" class="bio-field" readonly>{{ $profile->description }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Keahlian</label>
                            <textarea rows="4" placeholder="Keahlian Anda"
                                      name="keahlian" id="keahlian" readonly>{{ $profile->skill }}</textarea>
                        </div>
                    </div>

                    {{-- COLUMN 2: Contact & Social Links --}}
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" placeholder="Alamat" name="address" id="address"
                                   readonly value="{{ $profile->address }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" placeholder="Email" name="email" id="email"
                                   readonly value="{{ $profile->email }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Social Media</label>
                            <div class="social-links">
                                <input type="text" placeholder="Instagram" name="instagram" id="instagram"
                                       readonly value="{{ $profile->instagram }}">
                                <input type="text" placeholder="Twitter" name="twitter" id="twitter"
                                       readonly value="{{ $profile->twitter }}">
                                <input type="text" placeholder="Linkedin" name="linkedin" id="linkedin"
                                       readonly value="{{ $profile->linkedin }}">
                                <input type="text" placeholder="Facebook" name="facebook" id="facebook"
                                       readonly value="{{ $profile->facebook }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Website Pribadi</label>
                            <input type="text" placeholder="Website pribadi (opsional)" name="website"
                                   id="website" readonly value="{{ $profile->website }}">
                        </div>
                    </div>
                </div>

                <div class="profile-card-divider"></div>

                <div class="action">
                    <a href="{{ route('edit.profile') }}" class="btn-solid-accent"
                       style="text-decoration: none;">
                        Edit profil
                    </a>
                </div>
            </div>
        </div> {{-- /profile-right --}}
    </div> {{-- /profile-layout --}}
</div>

{{-- MODAL HAPUS – logika sama seperti sebelumnya --}}
<div class="modal fade" id="modalListDelete" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Karya</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                    @forelse ($artworks as $artwork)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>
                                {{-- tetap pakai URL gambar dari DB --}}
                                <img src="{{ $artwork->image }}" alt="artwork" width="50px">
                            </td>
                            <td class="description">{{ $artwork->description }}</td>
                            <td>{{ $artwork->category->name }}</td>
                            <td>
                                <form action="profile/{{ $artwork->id }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn-delete"
                                            onclick="return confirm('Are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak Ada Karya</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Toggle tab: Karya / Tentang --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnKarya   = document.getElementById('btn-karya');
    const btnTentang = document.getElementById('btn-tentang');
    const karyaCard  = document.querySelector('.my-artworks');
    const aboutCard  = document.querySelector('.about-me');

    if (!btnKarya || !btnTentang || !karyaCard || !aboutCard) return;

    function showKarya() {
        btnKarya.classList.add('active');
        btnTentang.classList.remove('active');
        karyaCard.style.display = 'block';
        aboutCard.style.display = 'none';
    }

    function showTentang() {
        btnTentang.classList.add('active');
        btnKarya.classList.remove('active');
        karyaCard.style.display = 'none';
        aboutCard.style.display = 'block';
    }

    btnKarya.addEventListener('click', showKarya);
    btnTentang.addEventListener('click', showTentang);

    // default
    showKarya();
});
</script>

@endsection
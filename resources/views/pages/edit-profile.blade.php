@extends('layouts.main')

@section('section')

<style>
:root {
    --page-bg-top: #fffdf8;
    --page-bg-bottom: #ffece5;

    --text-main: #123047;
    --text-muted: #7a8a99;

    --accent: #ff6b6b;
    --accent-soft: #ffe4e4;
    --accent-dark: #0b1120;

    --border-soft: #e1e7f0;
    --card-border: #e0e7ef;

    --radius-xl: 32px;
    --radius-lg: 26px;
    --radius-md: 18px;

    --shadow-soft: 0 14px 34px rgba(15, 23, 42, 0.08);
    --shadow-hover: 0 20px 52px rgba(15, 23, 42, 0.16);
}

/* PAGE WRAPPER */
.edit-profile-page {
    min-height: 100vh;
    padding: 3.5rem 0 4rem;
    background: linear-gradient(180deg, var(--page-bg-top), var(--page-bg-bottom));
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: var(--text-main);
}

/* CONTAINER UTAMA */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.6rem 3rem 2.8rem;
    background: radial-gradient(circle at top left, #ffffff, #fefcfb);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-soft);
    position: relative;
}

/* BACK BUTTON */
.profile-container .back {
    position: absolute;
    left: 1.9rem;
    top: 1.6rem;
    cursor: pointer;
    transition: transform .15s ease;
}

.profile-container .back:hover {
    transform: translateX(-3px);
}

/* HEADER: FOTO + NAMA */
.profile-info {
    display: flex;
    align-items: center;
    gap: 1.8rem;
    margin-bottom: 2.5rem;
    margin-top: .4rem;
    padding-left: 5rem;
}

.profile-info img {
    width: 118px;
    height: 118px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 20px 34px rgba(15, 23, 42, 0.22);
    background: #fff;
}

.profile-info .detail h4 {
    margin: 0;
    font-size: 1.65rem;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: var(--accent-dark);
}

.profile-info .detail p {
    margin: .15rem 0 .6rem;
    font-size: .95rem;
    color: var(--text-muted);
}

/* BUTTON GANTI FOTO */
.change-photo {
    border-radius: 999px;
    padding: .45rem 1.3rem;
    font-size: .8rem;
    border: 1px solid var(--card-border);
    background: #ffffff;
    color: var(--text-main);
    cursor: pointer;
    transition: all .15s ease-out;
}

.change-photo:hover {
    background: var(--accent);
    color: #ffffff;
    border-color: var(--accent);
    box-shadow: 0 8px 18px rgba(255, 107, 107, 0.32);
}

/* FORM WRAPPER */
.about-me {
    margin-top: .5rem;
}

/* GRID PROFIL */
.edit-profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
    align-items: start;
}

/* FORM GROUP */
.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* INPUT & TEXTAREA STYLE */
.about-me input,
.about-me textarea {
    width: 100%;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    padding: .85rem 1.1rem;
    font-size: .95rem;
    background: #ffffff;
    color: var(--text-main);
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.02);
    transition: border-color .2s ease, box-shadow .2s ease;
    font-family: system-ui, -apple-system, sans-serif;
    line-height: 1.5;
}

.about-me input:focus,
.about-me textarea:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
}

.about-me textarea {
    resize: vertical;
    min-height: 140px;
}

.about-me textarea.bio-field {
    min-height: 280px;
}

.about-me textarea.skill-field {
    min-height: 100px;
}

.about-me input::placeholder,
.about-me textarea::placeholder {
    color: #a4b1c2;
}

/* SOCIAL MEDIA GROUP */
.social-group {
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
}

/* TOMBOL SIMPAN */
.action-button-wrapper {
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-soft);
}

.btn-action {
    border-radius: 999px;
    padding: .85rem 3rem;
    font-size: .95rem;
    border: none;
    background: var(--accent);
    color: #ffffff;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 12px 26px rgba(255, 107, 107, 0.38);
    transition: transform .12s ease-out, filter .12s ease-out;
}

.btn-action:hover {
    filter: brightness(1.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

/* COLUMN SECTIONS */
.column-section {
    display: flex;
    flex-direction: column;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .edit-profile-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .profile-info {
        padding-left: 0;
        flex-direction: column;
        text-align: center;
    }

    .action-button-wrapper {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .profile-container {
        padding: 1.6rem 1.2rem;
    }

    .profile-container .back {
        position: relative;
        left: 0;
        top: 0;
        margin-bottom: 1rem;
    }

    .profile-info {
        padding-left: 0;
    }
}
</style>

<div class="edit-profile-page">
    @include('partials.alert')

    <div class="profile-container">
        <a href="{{ url()->previous() }}">
            <img src="{{ asset('images/back.png') }}" alt="back" width="40px" class="back">
        </a>

        {{-- HEADER PROFIL --}}
        <div class="profile-info mb-4">
            @if ($profile->image)
                <img src="{{ asset('storage/user/' . $profile->image) }}" alt="profile">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="profile">
            @endif

            <div class="detail">
                <h4>{{ auth()->user()->name }}</h4>
                <p>{{ auth()->user()->address }}</p>

                {{-- TOMBOL GANTI FOTO --}}
                <button class="change-photo" data-bs-toggle="modal" data-bs-target="#modalUpdatePhoto">
                    Perbarui Foto
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalUpdatePhoto" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ganti Foto Profil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('update.profile.photo') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <input type="file" class="form-control" id="customFile" name="image">
                                    <button type="submit" class="btn-action mt-3">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>{{-- /modal --}}
            </div>
        </div>

        {{-- FORM EDIT PROFIL --}}
        <div class="about-me d-block mt-2">
            <form action="{{ route('update.profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="edit-profile-grid">
                    {{-- KOLOM KIRI --}}
                    <div class="column-section">
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama lengkap" name="name" id="name" 
                                   value="{{ $profile->name }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bio">Biografi</label>
                            <textarea rows="12" placeholder="Ceritakan tentang diri Anda, pengalaman, dan minat Anda" 
                                      name="description" id="bio" class="bio-field">{{ $profile->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="keahlian">Keahlian</label>
                            <textarea placeholder="Contoh: UI/UX Design, Ilustrasi Digital, Fotografi" 
                                      name="skill" id="keahlian" class="skill-field">{{ $profile->skill }}</textarea>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="column-section">
                        <div class="form-group">
                            <label class="form-label" for="address">Alamat</label>
                            <input type="text" placeholder="Kota, Provinsi" name="address" id="address" 
                                   value="{{ $profile->address }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" placeholder="email@example.com" name="email" id="email" 
                                   value="{{ $profile->email }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Social Media</label>
                            <div class="social-group">
                                <input type="text" placeholder="Username Instagram" name="instagram" id="instagram"
                                       value="{{ $profile->instagram }}">
                                
                                <input type="text" placeholder="Username Twitter" name="twitter" id="twitter"
                                       value="{{ $profile->twitter }}">
                                
                                <input type="text" placeholder="Username LinkedIn" name="linkedin" id="linkedin"
                                       value="{{ $profile->linkedin }}">
                                
                                <input type="text" placeholder="Username Facebook" name="facebook" id="facebook"
                                       value="{{ $profile->facebook }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="website">Website Pribadi</label>
                            <input type="text" placeholder="https://yourwebsite.com (opsional)" name="website" id="website"
                                   value="{{ $profile->website }}">
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="action-button-wrapper">
                        <button class="btn-action" type="submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
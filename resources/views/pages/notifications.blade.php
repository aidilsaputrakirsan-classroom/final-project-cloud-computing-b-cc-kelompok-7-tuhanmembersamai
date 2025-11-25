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

    --chip-border: #d9e2ec;
    --card-border: #e0e7ef;
    --shadow-soft: 0 10px 26px rgba(15, 23, 42, 0.08);
    --shadow-hover: 0 14px 34px rgba(15, 23, 42, 0.15);
}

/* PAGE WRAPPER */
.notif-page {
    min-height: 100vh;
    padding: 3.5rem 0 4rem;
    background: linear-gradient(180deg, var(--page-bg-top), var(--page-bg-bottom));
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: var(--text-main);
}

.notif-container {
    max-width: 980px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* HEADER */
.notif-header {
    text-align: left;
    margin-bottom: 2rem;
}

.notif-header-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .25rem .9rem;
    border-radius: 999px;
    background: #fff;
    border: 1px solid #e5edf5;
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--text-muted);
    margin-bottom: .75rem;
}

.notif-header-eyebrow-dot {
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: var(--accent);
}

.notif-header h2 {
    font-size: clamp(2rem, 3vw, 2.4rem);
    font-weight: 700;
    letter-spacing: -0.04em;
    margin: 0 0 .4rem;
}

.notif-header p {
    margin: 0;
    font-size: .9rem;
    color: var(--text-muted);
}

/* GRID 2 KOLOM: LIKE & KOMENTAR */
.notif-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.6rem;
}

/* CARD KATEGORI NOTIF */
.notif-card {
    background: #ffffff;
    border-radius: 26px;
    border: 1px solid var(--card-border);
    padding: 1.4rem 1.6rem 1.3rem;
    box-shadow: var(--shadow-soft);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notif-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.notif-card-title {
    display: flex;
    align-items: center;
    gap: .6rem;
    font-weight: 600;
    font-size: 1rem;
}

.notif-pill {
    padding: .2rem .7rem;
    border-radius: 999px;
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    background: var(--accent-soft);
    color: var(--accent);
}

/* DAFTAR NOTIF */
.notif-list {
    display: flex;
    flex-direction: column;
    gap: .75rem;
    max-height: 420px;
    overflow-y: auto;
    padding-right: .3rem;
}

/* ITEM NOTIF */
.notif-item {
    display: flex;
    gap: .8rem;
    padding: .7rem .85rem;
    border-radius: 18px;
    background: #f9fbff;
    border: 1px solid #e5edf5;
    transition: transform .12s ease-out, box-shadow .12s ease-out, background .12s ease-out;
}

.notif-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    background: #ffffff;
}

.notif-avatar {
    width: 40px;
    height: 40px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

/* warna avatar beda untuk like & komentar */
.notif-like .notif-avatar {
    background: var(--accent-soft);
    color: var(--accent);
}

.notif-comment .notif-avatar {
    background: #e5f3ff;
    color: #2563eb;
}

/* TEKS NOTIF */
.notif-body {
    flex: 1;
}

.notif-body-main {
    font-size: .86rem;
    line-height: 1.4;
}

.notif-user {
    font-weight: 600;
}

.notif-artwork {
    font-style: italic;
    color: var(--text-main);
}

.notif-time {
    margin-top: .2rem;
    font-size: .75rem;
    color: var(--text-muted);
}

/* EMPTY STATE DALAM CARD */
.notif-empty {
    padding: 1.3rem 0 .7rem;
    text-align: center;
    font-size: .85rem;
    color: var(--text-muted);
}

/* SCROLLBAR HALUS */
.notif-list::-webkit-scrollbar {
    width: 6px;
}
.notif-list::-webkit-scrollbar-track {
    background: transparent;
}
.notif-list::-webkit-scrollbar-thumb {
    background: #d3dde7;
    border-radius: 999px;
}

/* RESPONSIVE */
@media (max-width: 576px) {
    .notif-container {
        padding-inline: 1rem;
    }
}
</style>

<div class="notif-page">
    <div class="notif-container">

        {{-- HEADER --}}
        <div class="notif-header">
            <div class="notif-header-eyebrow">
                <span class="notif-header-eyebrow-dot"></span>
                <span>Aktivitas Terbaru</span>
            </div>
            <h2>Notifikasi</h2>
            <p>Lihat siapa saja yang menyukai dan mengomentari karya kamu.</p>
        </div>

        {{-- GRID: LIKE & KOMENTAR --}}
        <div class="notif-grid">

            {{-- KOLOM LIKE --}}
            <div class="notif-card">
                <div class="notif-card-header">
                    <div class="notif-card-title">
                        <span>Like</span>
                    </div>
                    <span class="notif-pill">
                        {{ $likeNotif->count() }} aktivitas
                    </span>
                </div>

                <div class="notif-list">
                    @forelse ($likeNotif as $notif)
                        <div class="notif-item notif-like">
                            <div class="notif-avatar">
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="notif-body">
                                <div class="notif-body-main">
                                    <span class="notif-user">{{ $notif->user->name }}</span>
                                    menyukai karya kamu:
                                    <span class="notif-artwork">{{ $notif->artwork->description }}</span>
                                </div>
                                <div class="notif-time">
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="notif-empty">
                            Belum ada yang menyukai karya kamu.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- KOLOM KOMENTAR --}}
            <div class="notif-card">
                <div class="notif-card-header">
                    <div class="notif-card-title">
                        <span>Komentar</span>
                    </div>
                    <span class="notif-pill">
                        {{ $commentNotif->count() }} aktivitas
                    </span>
                </div>

                <div class="notif-list">
                    @forelse ($commentNotif as $notif)
                        <div class="notif-item notif-comment">
                            <div class="notif-avatar">
                                <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-body">
                                <div class="notif-body-main">
                                    <span class="notif-user">{{ $notif->user->name }}</span>
                                    mengomentari karya kamu:
                                    <span class="notif-artwork">“{{ $notif->message }}”</span>
                                </div>
                                <div class="notif-time">
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="notif-empty">
                            Belum ada komentar di karya kamu.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@extends('layouts.main')

@section('section')

<style>
/* ===========================
   LIGHT THEME – RECIPE STYLE (SESUAI MOCKUP)
   =========================== */

:root {
  /* pastel background lembut seperti screenshot */
  --page-bg-top: #fffdf8;
  --page-bg-bottom: #ffece5;

  --text-main: #123047;
  --text-muted: #7a8a99;

  /* tombol/search & chip aktif (coral / salmon) */
  --accent: #ff6b6b;
  --accent-soft: #ffe4e4;

  /* warna hijau tosca untuk tombol sekunder / hover */
  --accent-mint: #27c7a9;

  --chip-border: #d9e2ec;
  --card-border: #e0e7ef;
  --shadow-soft: 0 8px 20px rgba(15, 23, 42, 0.06);
  --shadow-hover: 0 12px 26px rgba(15, 23, 42, 0.12);
}

/* PAGE WRAPPER */
.exploration {
  min-height: 100vh;
  padding: 3.5rem 0 4rem;
  background: linear-gradient(180deg, var(--page-bg-top), var(--page-bg-bottom));
  color: var(--text-main);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* TOP SECTION / HERO */
.exploration .container-hero {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.exploration-header {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
  text-align: center;
  margin-bottom: 2.4rem;
}

.exploration-header .eyebrow {
  align-self: center;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.25rem 0.9rem;
  border-radius: 999px;
  background: #fff;
  border: 1px solid #e5edf5;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-muted);
}

.exploration-header .eyebrow-dot {
  width: 7px;
  height: 7px;
  border-radius: 999px;
  background: var(--accent);
}

.exploration-header h1.title {
  font-size: clamp(2.4rem, 4vw, 3.2rem);
  font-weight: 700;
  letter-spacing: -0.04em;
  margin: 0;
  color: #123047;
}

.exploration-header .subtitle {
  max-width: 640px;
  margin: 0 auto;
  font-size: 0.95rem;
  color: var(--text-muted);
}

/* ===========================
   SEARCH BAR – HERO STYLE
   =========================== */

.search-wrapper {
  position: relative;
  margin: 0 auto 1.6rem;
  max-width: 720px;
}

.search-shell {
  position: relative;
  border-radius: 999px;
  background: #ffffff;
  padding: 4px;
  box-shadow: var(--shadow-soft);
  border: 1px solid #e0e7ef;
}

.search-shell-inner {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  border-radius: 999px;
  background: #ffffff;
  padding: 0.35rem 0.7rem 0.35rem 0.9rem;
}

.search-prefix {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  border-radius: 999px;
  background: #f5f7fb;
  border: 1px solid #dde4ee;
  font-size: 0.8rem;
  color: var(--text-muted);
}

.search-input {
  flex: 1;
}

.search-input .form-control {
  border-radius: 999px;
  padding: 0.6rem 0.75rem;
  border: none;
  background: transparent;
  color: var(--text-main);
  font-size: 0.9rem;
  box-shadow: none;
}

.search-input .form-control::placeholder {
  color: #a0b0c0;
}

.search-input .form-control:focus {
  outline: none;
  box-shadow: none;
}

/* tombol Search coral bulat */
.input-group-append .btn {
  border-radius: 999px !important;
  padding-inline: 1.5rem;
  font-size: 0.9rem;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  border: none;
  background: var(--accent);
  color: #ffffff;
  font-weight: 600;
  box-shadow: 0 8px 18px rgba(255, 107, 107, 0.35);
}

.input-group-append .btn:hover {
  filter: brightness(1.04);
  transform: translateY(-1px);
}

.input-group-append .btn:active {
  transform: translateY(0);
  box-shadow: 0 4px 12px rgba(255, 107, 107, 0.35);
}

/* ===========================
   SEARCH SUGGESTION DROPDOWN
   =========================== */

.se-menu {
  position: absolute;
  left: 0;
  right: 0;
  margin-top: 0.4rem;
  padding: 0.3rem 0;
  background: #ffffff;
  border-radius: 1rem;
  border: 1px solid #e0e7ef;
  box-shadow: var(--shadow-soft);
  max-height: 240px;
  overflow-y: auto;
  display: none;
  z-index: 9999;
}

.se-menu li {
  list-style: none;
  cursor: pointer;
  padding: 0.55rem 1rem;
  font-size: 0.87rem;
  color: var(--text-main);
  display: flex;
  align-items: center;
}

.se-menu li:hover {
  background: #f5f7fb;
}

/* ===========================
   CATEGORY CHIPS
   =========================== */

.exploration-category {
  max-width: 1100px;
  margin: 0.6rem auto 0;
  padding: 0 1.5rem;
}

.choice-chip-container {
  gap: 0.6rem;
}

.choice-chip {
  border-radius: 999px;
  border: 1px solid var(--chip-border);
  padding: 0.45rem 1.2rem;
  background: #ffffff;
  color: var(--text-muted);
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.15s ease-out;
}

.choice-chip.active {
  background: var(--accent);
  border-color: var(--accent);
  color: #ffffff;
  box-shadow: 0 6px 16px rgba(255, 107, 107, 0.35);
}

.choice-chip:hover:not(.active) {
  background: #fdfdfd;
}

/* ===========================
   DIVIDER
   =========================== */

.exploration-divider {
  max-width: 1100px;
  margin: 1.4rem auto 1.8rem;
  padding: 0 1.5rem;
}

.exploration-divider hr {
  border-color: #e5edf5;
  margin: 0;
}

/* ===========================
   CARDS GRID – MIRIP RECIPE CARD
   =========================== */

.exploration-card {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1.5rem;
}

.exploration-card .row {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.8rem;
}

/* CARD */
.card-artworks {
  position: relative;
  border-radius: 26px;
  background: #ffffff;
  border: 1px solid var(--card-border);
  overflow: hidden;
  box-shadow: var(--shadow-soft);
  transform-origin: center;
  transition: transform 0.16s ease-out, box-shadow 0.16s ease-out;
}

.card-artworks a {
  display: block;
  overflow: hidden;
}

.card-artworks img.img-fluid {
  width: 100%;
  height: 230px;
  object-fit: cover;
  display: block;
  transition: transform 0.25s ease-out;
  border-bottom: 1px solid #f1f4f8;
}

.card-artworks:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-hover);
}

.card-artworks:hover img.img-fluid {
  transform: scale(1.03);
}

/* AUTHOR INFO (judul + deskripsi kecil) */
.author-info {
  display: flex;
  align-items: center;
  gap: 0.7rem;
  padding: 0.9rem 1rem 1rem;
}

.author-info img {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  object-fit: cover;
  border: 1px solid #e0e7ef;
  background: #f5f7fb;
}

.author-name {
  margin: 0;
  font-size: 0.85rem;
  color: var(--text-main);
}

.author-name strong {
  display: block;
  margin-bottom: 2px;
}

.author-name span {
  display: inline-block;
  font-size: 0.78rem;
  color: var(--text-muted);
}

/* EMPTY STATE */
.exploration-card .row > p {
  grid-column: 1 / -1;
  text-align: center;
  color: var(--text-muted);
  padding: 2rem 0;
  border-radius: 16px;
  border: 1px dashed #d3dde7;
  background: #ffffff;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .exploration {
    padding-top: 2.5rem;
  }

  .exploration-card .row {
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
  }

  .card-artworks img.img-fluid {
    height: 200px;
  }

  .exploration-header h1.title {
    font-size: 2.1rem;
  }
}
</style>

<div class="exploration">

  <div class="container-hero">
    <div class="exploration-header">
      <div class="eyebrow">
        <span class="eyebrow-dot"></span>
        <span>Eksplorasi Karya</span>
      </div>
      <h1 class="title">Temukan Ilustrasi & Karya Terbaik</h1>
      <p class="subtitle">
        Jelajahi karya berdasarkan kategori atau kata kunci deskripsi. Ketik sesuatu di kotak pencarian,
        pilih kategori, dan biarkan inspirasimu mengalir.
      </p>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-wrapper">
      <form id="explore-search-form" onsubmit="return false;">
        <div class="search-shell">
          <div class="search-shell-inner">
            <span class="search-prefix">
              <i class="fa fa-search"></i>
            </span>
            <div class="input-group search-input">
              <input type="text" id="se" class="form-control"
                     placeholder="Cari kategori, deskripsi, atau kata kunci terkait..."
                     autocomplete="off">
              <div class="input-group-append">
                <button id="search-btn" class="btn btn-danger" type="button">
                  <i class="fa fa-search"></i><span>Cari</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <ul class="se-menu" id="se-menu"></ul>
    </div>
  </div>

  <!-- CATEGORY CHIPS -->
  <div class="exploration-category mt-3 d-flex align-items-center">
    <div class="row w-100">
      <div class="choice-chip-container d-flex flex-wrap justify-content-center">
        @foreach ($categories as $category)
          <button class="choice-chip {{ $loop->first ? 'active' : '' }}"
                  data-category="{{ $category->name }}">
              {{ $category->name }}
          </button>
        @endforeach
      </div>
    </div>
  </div>

  <!-- DIVIDER -->
  <div class="exploration-divider">
    <hr>
  </div>

  <!-- ARTWORKS GRID -->
  <div class="exploration-card">
    <div class="row">
      @forelse ($artworks as $artwork)
        <div class="card-artworks"
             data-description="{{ Str::lower($artwork->description ?? '') }}"
             data-category="{{ Str::lower(optional($artwork->category)->name ?? '') }}">
          <a href="{{ route('eksplorasi.show', $artwork->id) }}">
            {{-- URL gambar langsung dari Supabase (tidak pakai asset/storage) --}}
            <img src="{{ $artwork->image }}" alt="Illustration" class="img-fluid">
          </a>
          <div class="author-info gap-2">
            @if ($artwork->user && $artwork->user->image)
              {{-- kalau kamu juga simpan URL foto user di DB --}}
              <img src="{{ $artwork->user->image }}" alt="author">
            @else
              <img src="{{ asset('images/default-profile.png') }}" alt="author">
            @endif

            <p class="author-name mt-1">
              <strong>{{ $artwork->user->name }}</strong>
              @if($artwork->description)
                <span>{!! Str::limit($artwork->description, 40, '...') !!}</span>
              @endif
            </p>
          </div>
        </div>
      @empty
        <p>Tidak ada karya</p>
      @endforelse
    </div>
  </div>

</div>

{{-- jQuery (hapus jika sudah ada di layout utama) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* LOGIKA PENCARIAN & FILTER TETAP SAMA – hanya dirapikan & disesuaikan dengan Supabase URL */
$(function () {
    const defaultProfile = "{{ asset('images/default-profile.png') }}";

    // ==== SUGGESTION LIST DARI CHIP + DESKRIPSI ====
    let suggestions = [];

    // kategori (choice-chip)
    $('.choice-chip').each(function () {
        let txt = $(this).text().trim();
        if (txt) suggestions.push(txt);
    });

    // deskripsi artwork yang sudah ter-render
    $('.card-artworks').each(function () {
        let desc = $(this).data('description') || '';
        if (desc) {
            let short = desc.length > 60 ? desc.slice(0, 60) + '...' : desc;
            if (!suggestions.some(s => s.toLowerCase() === short.toLowerCase())) {
                suggestions.push(short);
            }
        }
    });

    function showSuggestions(query) {
        const $menu = $('#se-menu');
        $menu.empty();

        if (!query || query.trim().length === 0) {
            $menu.hide();
            return;
        }

        const q = query.toLowerCase();
        const matches = suggestions.filter(s => s.toLowerCase().indexOf(q) !== -1);

        if (matches.length === 0) {
            $menu.hide();
            return;
        }

        matches.slice(0, 10).forEach(m => {
            $menu.append(`<li class="se-item">${$('<div>').text(m).html()}</li>`);
        });
        $menu.show();
    }

    $('#se').on('input', function () {
        showSuggestions($(this).val());
    });

    $(document).on('click', '.se-item', function () {
        const text = $(this).text();
        $('#se').val(text);
        $('#se-menu').hide();
        performSearch(text);
    });

    $(document).mouseup(function (e) {
        const container = $("#se, #se-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $("#se-menu").hide();
        }
    });

    $('#search-btn').on('click', function () {
        performSearch($('#se').val());
    });

    $('#se').on('keypress', function (e) {
        if (e.which === 13) {
            performSearch($(this).val());
            e.preventDefault();
            return false;
        }
    });

    // ==== AJAX SEARCH (kategori / deskripsi) ====
    function performSearch(query) {
        if (!query || query.trim().length === 0) {
            location.href = "{{ url('/eksplorasi') }}";
            return;
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi/search',
            type: 'POST',
            data: { query: query },
            success: function (response) {
                $('.exploration-card .row').empty();

                if (response.length > 0) {
                    $.each(response, function (index, artwork) {
                        const artworkImg = artwork.image; // URL langsung dari Supabase
                        const userImg    = (artwork.user && artwork.user.image)
                            ? artwork.user.image
                            : defaultProfile;
                        const authorName = (artwork.user && artwork.user.name)
                            ? artwork.user.name
                            : 'Unknown User';
                        const descShort  = artwork.description
                            ? (artwork.description.length > 40
                                ? artwork.description.slice(0, 40) + '...'
                                : artwork.description)
                            : '';

                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}">
                                    <img src="${artworkImg}" alt="Illustration" class="img-fluid">
                                </a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-1">
                                        <strong>${authorName}</strong>
                                        ${descShort ? `<span>${descShort}</span>` : ''}
                                    </p>
                                </div>
                            </div>
                        `;
                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    // ==== FILTER KATEGORI (CHOICE CHIP) ====
    $('.choice-chip').click(function () {
        $('.choice-chip').removeClass('active');
        $(this).addClass('active');
        const category = $(this).data('category');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi',
            type: 'POST',
            data: { category: category },
            success: function (response) {
                $('.exploration-card .row').empty();

                if (response.length > 0) {
                    $.each(response, function (index, artwork) {
                        const artworkImg = artwork.image;
                        const userImg    = (artwork.user && artwork.user.image)
                            ? artwork.user.image
                            : defaultProfile;
                        const authorName = (artwork.user && artwork.user.name)
                            ? artwork.user.name
                            : 'Unknown User';
                        const descShort  = artwork.description
                            ? (artwork.description.length > 40
                                ? artwork.description.slice(0, 40) + '...'
                                : artwork.description)
                            : '';

                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}">
                                    <img src="${artworkImg}" alt="Illustration" class="img-fluid">
                                </a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-1">
                                        <strong>${authorName}</strong>
                                        ${descShort ? `<span>${descShort}</span>` : ''}
                                    </p>
                                </div>
                            </div>
                        `;
                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});
</script>

@endsection

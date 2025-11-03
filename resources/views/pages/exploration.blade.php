@extends('layouts.main')

@section('section')

<style>
/* CSS untuk suggestion dropdown (dari CodePen yang kamu beri) */
.se-menu {
  position: absolute;
  left: 15px;
  right: 15px;
  padding: 0px;
  background-color: #fff;
  box-shadow: 0px 0px 10px 4px rgba(0,0,0,0.1);
  max-height: 200px;
  overflow-y: auto;
  display: none;
  z-index: 9999;
}
.se-menu li {
  list-style: none;
  cursor: pointer;
  padding: 10px 15px;
  border-bottom: 1px solid #f3f3f3;
}
.search-wrapper {
  position: relative; /* supaya .se-menu posisinya benar */
  margin-bottom: 1.5rem;
}
.search-input .form-control {
  border-radius: 50px;
  padding-left: 1.25rem;
}
</style>

<div class="exploration">

<!-- SEARCH BAR (di atas) -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="search-wrapper">
        <form id="explore-search-form" onsubmit="return false;">
          <div class="input-group search-input">
            <input type="text" id="se" class="form-control" placeholder="Cari kategori atau deskripsi..." autocomplete="off">
            <div class="input-group-append">
            <button id="search-btn" class="btn btn-danger" type="button">
                <i class="fa fa-search"></i> Cari
            </button>
            </div>

          </div>
        </form>
        <ul class="se-menu" id="se-menu"></ul>
      </div>
    </div>
  </div>
</div>

<h1 class="title">Eksplorasi</h1>

<div class="exploration-category mt-5 d-flex align-items-center">
    <div class="row">
        <div class="choice-chip-container d-flex flex-wrap justify-content-center">
            <button class="choice-chip active">Digital Art</button>
            <button class="choice-chip">Poster</button>
            <button class="choice-chip">Web Design</button>
            <button class="choice-chip">Wallpaper</button>
            <button class="choice-chip">Kerajinan Tangan</button>
            <button class="choice-chip">Ilustrasi</button>
            <button class="choice-chip">Portofolio</button>
            <button class="choice-chip">Typography</button>
            <button class="choice-chip">PowerPoint</button>
            <button class="choice-chip">Animasi</button>
            <button class="choice-chip">Tanah Liat</button>
        </div>
    </div>
</div>

<hr>

<div class="exploration-card">
    <div class="row">
        @forelse ($artworks as $artwork)
        <div class="card-artworks"
             data-description="{{ Str::lower($artwork->description ?? '') }}"
             data-category="{{ Str::lower($artwork->category ?? '') }}">
            <a href="{{ route('eksplorasi.show', $artwork->id) }}">
                <img src="{{ asset('storage/artwork/' . $artwork->image) }}" alt="Illustration" class="img-fluid">
            </a>
            <div class="author-info gap-2">
                @if ($artwork->user->image)
                <img src="{{ asset('storage/user/' . $artwork->user->image) }}" alt="author">
                @else
                <img src="{{ asset('images/default-profile.png') }}" alt="author">
                @endif
                <p class="author-name mt-3">{{ $artwork->user->name }}, {!! Str::limit($artwork->description, 10, '...') !!}</p>
            </div>
        </div>
        @empty
        <p>Tidak ada karya</p>
        @endforelse
    </div>
</div>

</div>

<!-- include jQuery (sudah ada di file awalmu) -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function() {
    // base URLs dari Blade (dipakai saat buat kartu dinamis via JS)
    const baseArtworkUrl = "{{ asset('storage/artwork/') }}";
    const baseUserUrl = "{{ asset('storage/user/') }}";
    const defaultProfile = "{{ asset('images/default-profile.png') }}";

    // 1) Siapkan array suggestion dari choice chips (kategori)
    let suggestions = [];
    $('.choice-chip').each(function(){
        let txt = $(this).text().trim();
        if (txt) suggestions.push(txt);
    });

    // 2) Tambahkan potongan description dari artworks yang ter-render di halaman
    $('.card-artworks').each(function(){
        let desc = $(this).data('description') || '';
        // ambil potongan (misal 0..50 chars) untuk suggestion agar tidak terlalu panjang
        if(desc) {
            let short = desc.length > 60 ? desc.slice(0,60) + '...' : desc;
            // push hanya jika belum ada (case-insensitive)
            if (!suggestions.some(s => s.toLowerCase() === short.toLowerCase())) suggestions.push(short);
        }
    });

    // helper: tampilkan suggestion dropdown berdasarkan input
    function showSuggestions(query) {
        const $menu = $('#se-menu');
        $menu.empty();
        if(!query || query.trim().length === 0) {
            $menu.hide();
            return;
        }
        const q = query.toLowerCase();
        // filter suggestions yang mengandung query
        const matches = suggestions.filter(s => s.toLowerCase().indexOf(q) !== -1);
        if(matches.length === 0) {
            $menu.hide();
            return;
        }
        matches.slice(0, 10).forEach(m => {
            $menu.append(`<li class="se-item">${$('<div>').text(m).html()}</li>`);
        });
        $menu.show();
    }

    // event: user mengetik
    $('#se').on('input', function(){
        const val = $(this).val();
        showSuggestions(val);
    });

    // klik suggestion -> isi input dan jalankan search
    $(document).on('click', '.se-item', function(){
        const text = $(this).text();
        $('#se').val(text);
        $('#se-menu').hide();
        performSearch(text);
    });

    // sembunyikan suggestion saat klik di luar
    $(document).mouseup(function (e) {
        var container = $("#se, #se-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $("#se-menu").hide();
        }
    });

    // tombol search ditekan
    $('#search-btn').on('click', function(){
        const q = $('#se').val();
        performSearch(q);
    });

    // enter di input juga search
    $('#se').on('keypress', function(e) {
        if(e.which === 13) {
            const q = $(this).val();
            performSearch(q);
            e.preventDefault();
            return false;
        }
    });

    // fungsi utama: kirim AJAX ke server untuk mencari berdasarkan category OR description
    function performSearch(query) {
        // jika kosong, kamu bisa memilih menampilkan semua karya atau tidak melakukan apa-apa
        if(!query || query.trim().length === 0) {
            // kosongkan filter: reload halaman (opsional)
            location.href = "{{ url('/eksplorasi') }}";
            return;
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi/search', // endpoint backend yang harus kamu siapkan
            type: 'POST',
            data: { query: query },
            success: function(response) {
                // response diharapkan array artworks (sama struktur dengan handler category)
                $('.exploration-card .row').empty();
                if (response.length > 0) {
                    $.each(response, function(index, artwork) {
                        // gunakan baseArtworkUrl / baseUserUrl dari atas
                        const artworkImg = artwork.image ? `${baseArtworkUrl}/${artwork.image}` : '';
                        const userImg = (artwork.user && artwork.user.image) ? `${baseUserUrl}/${artwork.user.image}` : defaultProfile;
                        const authorName = (artwork.user && artwork.user.name) ? artwork.user.name : 'Unknown User';
                        const descShort = artwork.description ? (artwork.description.length > 10 ? artwork.description.slice(0,10) + '...' : artwork.description) : '';
                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}"><img src="${artworkImg}" alt="Illustration" class="img-fluid"></a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-3">${authorName}, ${descShort}</p>
                                </div>
                            </div>
                        `;
                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    // ==== juga pertahankan behavior click pada choice-chip -> filter berdasarkan category ====
    $('.choice-chip').click(function() {
        $('.choice-chip').removeClass('active');
        $(this).addClass('active');
        var category = $(this).text();

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi',
            type: 'POST',
            data: { category: category },
            success: function(response) {
                $('.exploration-card .row').empty();
                if (response.length > 0) {
                    $.each(response, function(index, artwork) {
                        const artworkImg = artwork.image ? `${baseArtworkUrl}/${artwork.image}` : '';
                        const userImg = (artwork.user && artwork.user.image) ? `${baseUserUrl}/${artwork.user.image}` : defaultProfile;
                        const authorName = (artwork.user && artwork.user.name) ? artwork.user.name : 'Unknown User';
                        const descShort = artwork.description ? (artwork.description.length > 10 ? artwork.description.slice(0,10) + '...' : artwork.description) : '';
                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}"><img src="${artworkImg}" alt="Illustration" class="img-fluid"></a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-3">${authorName}, ${descShort}</p>
                                </div>
                            </div>
                        `;
                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

});
</script>

@endsection
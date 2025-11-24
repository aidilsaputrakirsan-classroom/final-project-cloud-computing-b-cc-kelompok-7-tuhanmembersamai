@extends('layouts.main')

@section('section')

<style>
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
  position: relative;
  margin-bottom: 1.5rem;
}
.search-input .form-control {
  border-radius: 50px;
  padding-left: 1.25rem;
}
</style>

<div class="exploration">

<!-- SEARCH BAR -->
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
            @foreach ($categories as $category)
                <button class="choice-chip {{ $loop->first ? 'active' : '' }}" data-category="{{ $category->name }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<hr>

<div class="exploration-card">
    <div class="row">
        @forelse ($artworks as $artwork)
        <div class="card-artworks"
             data-description="{{ Str::lower($artwork->description ?? '') }}"
             data-category="{{ Str::lower(optional($artwork->category)->name ?? '') }}">
            <a href="{{ route('eksplorasi.show', $artwork->id) }}">
                <img src="{{ $artwork->image }}" alt="Illustration" class="img-fluid">
            </a>

            <div class="author-info gap-2">
                @if ($artwork->user->image)
                <img src="{{ asset('images/default-profile.png') }}" alt="author">
                @else
                <img src="{{ asset('images/default-profile.png') }}" alt="author">
                @endif

                <p class="author-name mt-3">
                    {{ $artwork->user->name }},
                    {!! Str::limit($artwork->description, 10, '...') !!}
                </p>
            </div>
        </div>
        @empty
        <p>Tidak ada karya</p>
        @endforelse
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function() {

    // BASE URL Supabase
    const SUPABASE_URL = "https://ejxrzekncqjgkpclools.supabase.co/storage/v1/object/public/";

    // === Suggestions setup ===
    let suggestions = [];
    $('.choice-chip').each(function(){
        let txt = $(this).text().trim();
        if (txt) suggestions.push(txt);
    });

    $('.card-artworks').each(function(){
        let desc = $(this).data('description') || '';
        if(desc) {
            let short = desc.length > 60 ? desc.slice(0,60) + '...' : desc;
            if (!suggestions.some(s => s.toLowerCase() === short.toLowerCase()))
                suggestions.push(short);
        }
    });

    function showSuggestions(query) {
        const $menu = $('#se-menu');
        $menu.empty();
        if(!query.trim()) return $menu.hide();
        const q = query.toLowerCase();

        const matches = suggestions.filter(s => s.toLowerCase().includes(q));
        if(matches.length === 0) return $menu.hide();

        matches.slice(0, 10).forEach(m => $menu.append(`<li class="se-item">${m}</li>`));
        $menu.show();
    }

    $('#se').on('input', function(){ showSuggestions($(this).val()); });

    $(document).on('click', '.se-item', function(){
        const text = $(this).text();
        $('#se').val(text);
        $('#se-menu').hide();
        performSearch(text);
    });

    $(document).mouseup(function (e) {
        var container = $("#se, #se-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $("#se-menu").hide();
        }
    });

    $('#search-btn').on('click', function(){ performSearch($('#se').val()); });

    $('#se').on('keypress', function(e) {
        if(e.which === 13) {
            performSearch($('#se').val());
            e.preventDefault();
        }
    });

    function performSearch(query) {
        if(!query.trim()) {
            location.href = "{{ url('/eksplorasi') }}";
            return;
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi/search',
            type: 'POST',
            data: { query: query },
            success: function(response) {
                $('.exploration-card .row').empty();
                if (response.length > 0) {
                    $.each(response, function(index, artwork) {
                        // gunakan baseArtworkUrl / baseUserUrl dari atas
                        const artworkImg = artwork.image;
                        const userImg = (artwork.user && artwork.user.image) ? `${baseUserUrl}/${artwork.user.image}` : defaultProfile;
                        const authorName = (artwork.user && artwork.user.name) ? artwork.user.name : 'Unknown User';
                        const descShort = artwork.description ? (artwork.description.length > 10 ? artwork.description.slice(0,10) + '...' : artwork.description) : '';
                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}">
                                    <img src="${artworkImg}" class="img-fluid">
                                </a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-3">${artwork.user.name}, ${artwork.description.slice(0,10)}...</p>
                                </div>
                            </div>
                        `;
                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            }
        });
    }

    $('.choice-chip').click(function() {
        $('.choice-chip').removeClass('active');
        $(this).addClass('active');

        var category = $(this).data('category');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/eksplorasi',
            type: 'POST',
            data: { category: category },
            success: function(response) {
                $('.exploration-card .row').empty();

                if (response.length > 0) {
                    $.each(response, function(index, artwork) {
                        const artworkImg = `${SUPABASE_URL}${artwork.image}`;
                        const userImg = "{{ asset('images/default-profile.png') }}";

                        const card = `
                            <div class="card-artworks">
                                <a href="/eksplorasi/${artwork.id}">
                                    <img src="${artworkImg}" class="img-fluid">
                                </a>
                                <div class="author-info gap-2">
                                    <img src="${userImg}" alt="author">
                                    <p class="author-name mt-3">${artwork.user.name}, ${artwork.description.slice(0,10)}...</p>
                                </div>
                            </div>
                        `;

                        $('.exploration-card .row').append(card);
                    });
                } else {
                    $('.exploration-card .row').append('<p>Tidak ada karya</p>');
                }
            }
        });
    });

});
</script>

@endsection

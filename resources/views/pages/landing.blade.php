@extends('layouts.main')

@section('section')
<div class="hero">
    <div class="hero-content">
        <h1>Bikin karya?</h1>
        <h1>Ayo, tunjukin karyamu!</h1>
        <p><strong>Galeri Karya Indonesia</strong> hadir untuk memberikan tempat bagi semua orang membagikan karya dan
            portofolio</p>
        <div class="share">
            <a href="{{ route('login') }}" class="btn-share">Share Sekarang</a>
            <img src="{{ asset('images/arrow-right2.png') }}" alt="arrow" width="16px">
        </div>
    </div>
    <div class="hero-image">
    </div>
</div>
<div class="about" id="aboutme">
    <h1>Tentang Kami</h1>
    <div class="about-content mt-4">
        <p>Selamat datang di GallerySI, tempat bagi para kreator yang ingin berbagi karya mereka dengan
            dunia.
            Kami hadir dengan memberikan platform yang memungkinkan individu untuk memperluas jangkauan dan pengaruh
            dari
            karya-karya mereka.</p>
        <p>GallerySI menyediakan ruang untuk para kreator memamerkan bakat mereka dalam berbagai bentuk, mulai dari gambar,
            desain, tulisan, hingga karya-karya kreatif lainnya.</p>
        <p>Bergabunglah dengan GallerySI dan jadilah bagian dari perjalanan kreatif ini. Mari bersama-sama menciptakan
            ruang di
            mana setiap karya dihargai, setiap pencapaian diakui, dan setiap individu diberdayakan untuk berkembang dan
            bersinar dalam dunia kreatif.</p>
    </div>
</div>
<div class="benefits">
    <h1>Fitur Utama</h1>
    <div class="benefit-content">
        <div class="card">
            <img src="{{ asset('images/benefit-1.png') }}" alt="benefit1" class="benefit-img mt-3">
            <h2 class="mt-2">Share Karya Kamu</h2>
            <p class="mt-2">kamu bisa mengekspresikan diri kamu, memperluas jaringan, dan memperoleh inspirasi dari
                komunitas yang
                beragam.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/benefit-2.png') }}" alt="benefit1" class="benefit-img mt-3">
            <h2 class="mt-2">Unggah Karya</h2>
            <p class="mt-2">memberikan akses yang lebih mudah bagi kamu untuk memperkenalkan karya-karya kamu kepada
                pihak organisasi atau perusahaan dibidang kreatif.</p>
        </div>
        <div class="card">
            <img src="{{ asset('images/benefit-3.png') }}" alt="benefit1" class="benefit-img mt-3">
            <h2 class="mt-2">Sukai dan komentar</h2>
            <p class="mt-2">memberikan kamu kesempatan untuk menyatakan apresiasi, memberikan umpan balik, dan
                memperdalam hubungan antar pengguna serta konten yang dibagikan.</p>
        </div>
    </div>
</div>
<div class="explore">
    <h1>Eksplorasi</h1>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($explorations as $exploration)
            <div class="swiper-slide">
                <img style="aspect-ratio: 1/1; object-fit: cover;"
                    src="{{ asset('storage/artwork/' . $exploration->image) }}" />
            </div>
            @endforeach

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div class="others">
        <a href="{{ route('eksplorasi.index') }}" class="btn-other">Lainnya</a>
        <a href="{{ route('eksplorasi.index') }}"><img src="{{ asset('images/arrow-right2.png') }}" alt="arrow"
                width="16px"></a>
    </div>
</div>
@endsection

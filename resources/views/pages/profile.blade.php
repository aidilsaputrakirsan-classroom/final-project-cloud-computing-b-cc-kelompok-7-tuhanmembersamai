@extends('layouts.main')

@section('section')
    <div class="profile-container">
        <a href="{{ route('landing') }}"><img src="{{ asset('images/back.png') }}" alt="back" width="40px"
                class="back"></a>
        <div class="profile-info">
            @if ($profile->image)
                <img src="{{ asset('storage/user/' . $profile->image) }}" alt="profile">
            @else
                <img src="{{ asset('images/default-profile.png') }}" alt="profile">
            @endif
            <div class="detail">
                <h4>{{ auth()->user()->name }}</h4>
                <p>{{ auth()->user()->address }}</p>
            </div>
        </div>
        <div class="menu">
            <button class="btn-menu active" id="btn-karya">Karya kamu</button>
            <button class="btn-menu" id="btn-tentang">Tentang kamu</button>
        </div>
        <hr>
        <div class="my-artworks">
            @include('partials.alert')
            <div class="action mt-2">
                <button type="button" class="btn-action" data-bs-toggle="modal"
                    data-bs-target="#modalListDelete">Hapus</button>
                <!-- Modal -->
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
                                <table class="table table-striped">
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
                                        @php
                                            $no = 1;
                                        @endphp
                                        @forelse ($artworks as $artwork)
                                            <tr>
                                                <th scope="row">{{ $no++ }}</th>
                                                <td><img src="{{ asset('storage/artwork/' . $artwork->image) }}"
                                                        alt="artwork" width="50px"></td>
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
                                            <p>Tidak Ada Karya</p>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn-action" class="dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">Unggah</button>
                    <ul class="dropdown-menu upload">
                        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" id="inputfile" aria-describedby="inputgroupfile"
                                    aria-label="Upload" class="input-upload" name="image">
                            </div>
                            <div class="mb-3">
                                <label for="description">Tambahkan deskripsi</label>
                                <textarea type="text" name="description" id="description"></textarea>
                            </div>
                            <div class="mb-5">
                                <select class="form-select" aria-label="select-category" name="category_id">
                                    <option selected>Tambahkan kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn-action">ok</button>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
            <div class="artwork-content">
                @forelse ($artworks as $artwork)
                    <div class="card-artwork">
                        <img src="{{ asset('storage/artwork/' . $artwork->image) }}" alt="artwork">
                    </div>
                @empty
                    <p>Tidak Ada Karya</p>
                @endforelse

            </div>
        </div>
        <div class="about-me">
            <div class="d-flex flex-row w-100 px-5">
                <div class="col-lg-6 px-2">
                    <div class="mb-4">
                        <input type="text" placeholder="Nama" name="name" id="name" readonly
                            value="{{ $profile->name }}">
                    </div>
                    <div class="mb-4">
                        <textarea rows="16" type="text" placeholder="Biografi atau deskripsi diri" name="bio" id="bio"
                            readonly>{{ $profile->description }}</textarea>
                    </div>
                    <div class="mt-1">
                        <textarea type="text" placeholder="Keahlian" name="keahlian" id="keahlian" readonly>{{ $profile->skill }}</textarea>
                    </div>
                </div>
                <div class="col-lg-3 px-2 mt-5">
                    <div class="mt-3 mb-3">
                        <input type="text" placeholder="Alamat" name="address" id="address" readonly
                            value="{{ $profile->address }}">
                    </div>
                    <div class="mb-5">
                        <input type="email" placeholder="Email" name="email" id="email" readonly
                            value="{{ $profile->email }}">
                    </div>
                    <div class="mb-2">
                        <input type="text" placeholder="Instagram" name="instagram" id="instagram" readonly
                            value="{{ $profile->instagram }}">
                    </div>
                    <div class="mb-2">
                        <input type="text" placeholder="Twitter" name="twitter" id="twitter" readonly
                            value="{{ $profile->twitter }}">
                    </div>
                    <div class="mb-2">
                        <input type="text" placeholder="Linkedin" name="linkedin" id="linkedin" readonly
                            value="{{ $profile->linkedin }}">
                    </div>
                    <div class="mb-2">
                        <input type="text" placeholder="Facebook" name="facebook" id="facebook" readonly
                            value="{{ $profile->facebook }}">
                    </div>
                    <div class="mb-2">
                        <input type="text" placeholder="Website pribadi (opsional)" name="website" id="website"
                            readonly value="{{ $profile->website }}">
                    </div>
                </div>
                <div class="col-lg-3 w-25">
                    <div class="action">
                        <a href="{{ route('edit.profile') }}" style="text-decoration: none;" class="btn-action">Edit
                            profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

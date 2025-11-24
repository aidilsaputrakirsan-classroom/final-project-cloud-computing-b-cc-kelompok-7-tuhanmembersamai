@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- SECTION: STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 shadow rounded-lg border-l-4 border-blue-500">
            <h3 class="text-xl font-semibold text-gray-700">Total Category</h3>
            <p class="text-3xl font-bold mt-2">{{ $total_categories }}</p>
        </div>

        <div class="bg-white p-6 shadow rounded-lg border-l-4 border-green-500">
            <h3 class="text-xl font-semibold text-gray-700">Total Post</h3>
            <p class="text-3xl font-bold mt-2">{{ $total_posts }}</p>
        </div>

        <div class="bg-white p-6 shadow rounded-lg border-l-4 border-purple-500">
            <h3 class="text-xl font-semibold text-gray-700">Total User</h3>
            <p class="text-3xl font-bold mt-2">{{ $total_users }}</p>
        </div>

    </div>


    {{-- SECTION: LATEST POSTS --}}
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Postingan Terbaru</h2>

        @if($latest_posts->isEmpty())
            <p class="text-gray-500">Belum ada postingan.</p>
        @else
            <div class="space-y-4">

                @foreach($latest_posts as $post)
                    <div class="flex items-center gap-4 p-3 border rounded hover:bg-gray-50 transition">

                        {{-- Thumbnail --}}
                        @if($post->image)
                            <img src="{{ $post->image }}" 
                                 class="w-20 h-20 object-cover rounded shadow" alt="">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg">
                                <a href="{{ route('admin.posts.show', $post) }}" class="hover:underline">
                                    {{ Str::limit($post->description, 40) }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-600">
                                {{ $post->created_at->format('d M Y • H:i') }}
                            </p>

                            <p class="text-sm text-gray-600">
                                Kategori: <b>{{ $post->category->name ?? '-' }}</b>
                            </p>
                        </div>

                        {{-- Button --}}
                        <a href="{{ route('admin.posts.show', $post) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                           Lihat
                        </a>

                    </div>
                @endforeach

            </div>
        @endif
    </div>

</div>

@endsection

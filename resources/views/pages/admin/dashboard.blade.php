@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- SECTION: STATISTICS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

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

        <div class="bg-white p-6 shadow rounded-lg border-l-4 border-orange-500">
            <h3 class="text-xl font-semibold text-gray-700">Total Activity Log</h3>
            <p class="text-3xl font-bold mt-2">{{ $total_activity_logs }}</p>
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


    {{-- SECTION: LATEST ACTIVITY LOGS --}}
    <div class="bg-white p-6 shadow rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Activity Log Terbaru</h2>
            <a href="{{ route('admin.activity-logs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Lihat Semua →
            </a>
        </div>

        @if($latest_activity_logs->isEmpty())
            <p class="text-gray-500">Belum ada activity log.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">User</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Action</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latest_activity_logs as $log)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3">
                                    @if($log->user)
                                        <div class="flex items-center gap-2">
                                            @if($log->user->image)
                                                <img src="{{ asset('storage/user/' . $log->user->image) }}" 
                                                     class="w-6 h-6 rounded-full object-cover" alt="">
                                            @else
                                                <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center text-xs font-bold">
                                                    {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="text-sm">{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-xs">-</span>
                                    @endif
                                </td>
                                
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        @if(strpos($log->action, 'admin_') === 0)
                                            bg-red-100 text-red-800
                                        @elseif(strpos($log->action, 'delete') !== false || strpos($log->action, 'unlike') !== false)
                                            bg-orange-100 text-orange-800
                                        @elseif(strpos($log->action, 'upload') !== false || strpos($log->action, 'create') !== false)
                                            bg-green-100 text-green-800
                                        @elseif(strpos($log->action, 'login') !== false || strpos($log->action, 'logout') !== false)
                                            bg-purple-100 text-purple-800
                                        @else
                                            bg-blue-100 text-blue-800
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="truncate text-gray-600 text-sm max-w-xs" title="{{ $log->description }}">
                                        {{ Str::limit($log->description ?? '-', 30) }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-xs text-gray-600">
                                    {{ $log->created_at->format('d M Y • H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection

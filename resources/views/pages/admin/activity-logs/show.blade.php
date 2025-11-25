@extends('layouts.admin')
@section('title', 'Detail Activity Log')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Detail Activity Log</h1>
        <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
            Kembali
        </a>
    </div>

    {{-- DETAIL SECTION --}}
    <div class="bg-white p-8 shadow rounded-lg">
        
        {{-- Info User --}}
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-semibold mb-4">Informasi User</h2>
            
            @if($activityLog->user)
                <div class="flex items-center gap-6">
                    @if($activityLog->user->image)
                        <img src="{{ asset('storage/user/' . $activityLog->user->image) }}" 
                             class="w-16 h-16 rounded-full object-cover" alt="">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($activityLog->user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div>
                        <p class="text-lg font-semibold">{{ $activityLog->user->name }}</p>
                        <p class="text-gray-600">{{ $activityLog->user->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Bergabung: {{ $activityLog->user->created_at->format('d M Y • H:i') }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-500 italic">User tidak ditemukan atau sudah dihapus</p>
            @endif
        </div>

        {{-- Activity Details --}}
        <div class="mb-8 pb-8 border-b border-gray-200">
            <h2 class="text-xl font-semibold mb-4">Detail Activity</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Action --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                            @if(strpos($activityLog->action, 'admin_') === 0)
                                bg-red-100 text-red-800
                            @elseif(strpos($activityLog->action, 'delete') !== false || strpos($activityLog->action, 'unlike') !== false)
                                bg-orange-100 text-orange-800
                            @elseif(strpos($activityLog->action, 'upload') !== false || strpos($activityLog->action, 'create') !== false)
                                bg-green-100 text-green-800
                            @elseif(strpos($activityLog->action, 'login') !== false || strpos($activityLog->action, 'logout') !== false)
                                bg-purple-100 text-purple-800
                            @else
                                bg-blue-100 text-blue-800
                            @endif
                        ">
                            {{ ucfirst(str_replace('_', ' ', $activityLog->action)) }}
                        </span>
                    </div>
                </div>

                {{-- Timestamp --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="font-medium">{{ $activityLog->created_at->format('d M Y • H:i:s') }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            {{ $activityLog->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $activityLog->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

    </div>

</div>

@endsection

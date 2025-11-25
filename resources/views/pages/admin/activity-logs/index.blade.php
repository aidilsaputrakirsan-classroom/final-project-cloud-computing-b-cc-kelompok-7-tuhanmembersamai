@extends('layouts.admin')
@section('title', 'Activity Log')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Activity Log</h1>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Filter</h2>
        
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            
            {{-- Filter User --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Action --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Action</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" 
                            {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $action)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Date From --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Filter Date To --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Button --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition w-full">
                    Filter
                </button>
                <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition w-full text-center">
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- ACTIVITY LOGS TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Daftar Activity Log</h2>
            <p class="text-sm text-gray-600">Total: {{ $logs->total() }} log</p>
        </div>

        @if($logs->isEmpty())
            <div class="p-6 text-center text-gray-500">
                Tidak ada activity log.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">No</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">User</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Action</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Waktu</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($log->user)
                                        <div class="flex items-center gap-2">
                                            @if($log->user->image)
                                                <img src="{{ asset('storage/user/' . $log->user->image) }}" 
                                                     class="w-8 h-8 rounded-full object-cover" alt="">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs font-bold">
                                                    {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="font-medium">{{ $log->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
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

                                <td class="px-6 py-4 max-w-xs">
                                    <div class="truncate text-gray-600 text-sm" title="{{ $log->description }}">
                                        {{ $log->description ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div>{{ $log->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.activity-logs.show', $log) }}" 
                                       class="inline-block px-3 py-1 text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="p-6 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

@endsection

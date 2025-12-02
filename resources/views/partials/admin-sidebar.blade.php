<!-- resources/views/partials/admin-sidebar.blade.php -->
<aside class="w-64 bg-gradient-to-b from-indigo-700 via-blue-700 to-blue-900 text-white shadow-2xl flex flex-col min-h-screen">
    <!-- Header -->
    <div class="p-6 border-b border-blue-600/30 bg-black/10 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center shadow-lg">
                <i class="fas fa-admin text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Admin</h2>
                <p class="text-xs text-blue-200">Control Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation - Grows to fill available space -->
    <nav class="flex-1 mt-8 px-4 overflow-y-auto">
        <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-4">Menu Utama</p>
        
        <ul class="space-y-3">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-3 flex items-center rounded-lg transition duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-600/50' }}">
                    <i class="fas fa-home mr-3 text-lg group-hover:scale-110 transition transform"></i>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </li>

            {{-- Users --}}
            <li>
                <a href="{{ route('admin.users') }}"
                   class="px-4 py-3 flex items-center rounded-lg transition duration-300 group {{ request()->routeIs('admin.users') ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-600/50' }}">
                    <i class="fas fa-users mr-3 text-lg group-hover:scale-110 transition transform"></i>
                    <span class="font-medium">Kelola User</span>
                    @if(request()->routeIs('admin.users'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </li>

            {{-- Posts --}}
            <li>
                <a href="{{ route('admin.posts.index') }}"
                   class="px-4 py-3 flex items-center rounded-lg transition duration-300 group {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-600/50' }}">
                    <i class="fas fa-file-alt mr-3 text-lg group-hover:scale-110 transition transform"></i>
                    <span class="font-medium">Kelola Post</span>
                    @if(request()->routeIs('admin.posts.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </li>

            {{-- Categories --}}
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-3 flex items-center rounded-lg transition duration-300 group {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-600/50' }}">
                    <i class="fas fa-folder mr-3 text-lg group-hover:scale-110 transition transform"></i>
                    <span class="font-medium">Kelola Categories</span>
                    @if(request()->routeIs('admin.categories.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </li>

            {{-- Activity Log --}}
            <li>
                <a href="{{ route('admin.activity-logs.index') }}"
                   class="px-4 py-3 flex items-center rounded-lg transition duration-300 group {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-600/50' }}">
                    <i class="fas fa-chart-line mr-3 text-lg group-hover:scale-110 transition transform"></i>
                    <span class="font-medium">Activity Log</span>
                    @if(request()->routeIs('admin.activity-logs.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </li>
        </ul>
    </nav>

    <!-- Quick Actions & Footer - Pushed to bottom -->
    <div class="mt-auto px-4 pt-6 pb-4 border-t border-blue-600/30">
        <!-- Quick Actions -->
        <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-3">Aksi</p>
        
        <form action="{{ route('admin.logout') }}" method="POST" class="block mb-6">
            @csrf
            <button type="submit" 
                    class="w-full px-4 py-3 flex items-center rounded-lg text-red-100 hover:bg-red-600/50 transition duration-300 group">
                <i class="fas fa-sign-out-alt mr-3 text-lg group-hover:scale-110 transition transform"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>

        <!-- Footer -->
        <div class="bg-blue-600/20 backdrop-blur-sm rounded-lg p-3 text-center border border-blue-500/20">
            <p class="text-xs text-blue-200">
                <i class="fas fa-info-circle mr-1"></i>
                Admin Panel v1.0
            </p>
            <p class="text-xs text-blue-300/60 mt-1">© 2025 All Rights</p>
        </div>
    </div>
</aside>

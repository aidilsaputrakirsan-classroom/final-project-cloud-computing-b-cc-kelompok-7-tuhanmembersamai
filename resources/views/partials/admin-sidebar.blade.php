<!-- Sidebar -->
<aside class="w-64 bg-blue-700 text-white min-h-screen">
    <div class="p-4 text-xl font-semibold border-b border-blue-500">
        Admin Panel
    </div>
    <nav class="mt-4">
        <ul>
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.users') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.users') }}">👥 Kelola User</a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.posts') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.posts') }}">📝 Kelola Post</a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('categories.index') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('categories.index') }}">🗂️ Kelola Categories</a>
            </li>

        </ul>
    </nav>
</aside>

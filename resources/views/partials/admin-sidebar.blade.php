<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">

    <!-- resources/views/partials/admin-sidebar.blade.php -->
<aside class="w-64 bg-blue-700 text-white min-h-screen">
    <div class="p-4 text-xl font-semibold border-b border-blue-500">
        Admin Panel
    </div>

    <nav class="mt-4">
        <ul>

            {{-- Dashboard --}}
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
            </li>

            {{-- Users --}}
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.users') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.users') }}">👥 Kelola User</a>
            </li>

            {{-- Posts --}}
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.posts.index') }}">📝 Kelola Post</a>
            </li>

            {{-- Categories --}}
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.categories.index') }}">🗂️ Kelola Categories</a>
            </li>

            {{-- Activity Log --}}
            <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600' : '' }}">
                <a href="{{ route('admin.activity-logs.index') }}">📊 Activity Log</a>
            </li>

            {{-- Logout --}}
            <li class="px-4 py-2 hover:bg-blue-600 mt-4 border-t border-blue-500">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left">
                        🚪 Logout
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</aside>


</body>
</html>

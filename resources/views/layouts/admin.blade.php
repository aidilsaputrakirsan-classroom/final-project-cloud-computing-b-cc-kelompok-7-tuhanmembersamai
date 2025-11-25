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

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white min-h-screen">
        <div class="p-4 text-xl font-semibold border-b border-blue-500">
            Admin Panel
        </div>
        <nav class="mt-4">
            <ul>
                <li class="px-4 py-2 hover:bg-blue-600">
                    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
                </li>
                <li class="px-4 py-2 hover:bg-blue-600">
                    <a href="{{ route('admin.users') }}">👥 Kelola User</a>
                </li>
                <li class="px-4 py-2 hover:bg-blue-600">
                    <a href="{{ route('admin.posts.index') }}">📝 Kelola Post</a>
                </li>
               <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.categories.index') ? 'bg-blue-600' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">🗂️ Kelola Categories</a>
                </li>
                <li class="px-4 py-2 hover:bg-blue-600 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600' : '' }}">
                    <a href="{{ route('admin.activity-logs.index') }}">📊 Activity Log</a>
                </li>

            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6">@yield('title')</h1>
        @yield('content')
    </main>

</body>
</html>

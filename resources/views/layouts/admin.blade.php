<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>

    <!-- your css -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar-wrapper {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        .admin-sidebar-wrapper aside {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .admin-sidebar-wrapper aside nav {
            flex: 1;
            overflow-y: auto;
            padding-right: 8px;
        }

        .admin-sidebar-wrapper aside nav::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar-wrapper aside nav::-webkit-scrollbar-track {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
            margin: 10px 0;
        }

        .admin-sidebar-wrapper aside nav::-webkit-scrollbar-thumb {
            background: rgba(147, 197, 253, 0.5);
            border-radius: 10px;
        }

        .admin-sidebar-wrapper aside nav::-webkit-scrollbar-thumb:hover {
            background: rgba(147, 197, 253, 0.8);
        }

        .admin-main {
            flex: 1;
            overflow-y: auto;
            max-height: 100vh;
        }

        .admin-main::-webkit-scrollbar {
            width: 8px;
        }

        .admin-main::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .admin-main::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .admin-main::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        {{-- sidebar --}}
        <div class="admin-sidebar-wrapper">
            @include('partials.admin-sidebar')
        </div>

        <!-- Main Content -->
        <main class="admin-main p-8">
            <header class="mb-6">
                <h1 class="text-4xl font-bold text-gray-800">@yield('title')</h1>
                <p class="text-gray-600 mt-1">Kelola aplikasi dari halaman ini</p>
            </header>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 text-red-700 border-l-4 border-red-500 rounded shadow-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>

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
</head>
<body class="bg-gray-100 flex min-h-screen">

    {{-- sidebar --}}
    @include('partials.admin-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <header class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">@yield('title')</h1>
            {{-- optional: place for breadcrumbs / quick actions --}}
        </header>

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-100 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>

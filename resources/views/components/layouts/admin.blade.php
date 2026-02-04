<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-100 text-base-content">
    
    <div class="drawer lg:drawer-open">
        
        <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />
        
        <div class="drawer-content">
            
            <x-layouts.header />
            
            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
        
        <!-- Sidebar -->
        <x-layouts.admin.sidebar />
    </div>
    
</body>
</html>

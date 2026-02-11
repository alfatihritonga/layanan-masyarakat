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
        
        <div class="drawer-content flex flex-col">
            
            <x-layouts.header />
            
            <main>
                @if (session('success'))
                    <div class="px-4 pt-4">
                        <div role="alert" class="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="intentui-icons size-4" data-slot="icon" aria-hidden="true"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9.5 10.5 15l-2-2m12.75-1a9.25 9.25 0 1 1-18.5 0 9.25 9.25 0 0 1 18.5 0"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
        
        <!-- Sidebar -->
        <x-layouts.admin.sidebar />
    </div>
    
</body>
</html>

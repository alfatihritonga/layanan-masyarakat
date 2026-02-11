<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-base-100 text-base-content">
    
    <div class="drawer lg:drawer-open">
        
        <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />
        
        <div class="drawer-content flex flex-col">
            
            <x-admin-navbar />
            
            <main class="p-6">
                <!-- Breadcrumb -->
                @if(isset($breadcrumbs))
                <div class="breadcrumbs text-sm mb-4">
                    <ul>
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="font-semibold">{{ $breadcrumb['title'] }}</li>
                            @else
                                <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Alert Messages -->
                @if(session('success'))
                <x-alert type="success" :message="session('success')" />
                @endif
                
                @if(session('error'))
                <x-alert type="error" :message="session('error')" />
                @endif
                
                @if($errors->any())
                <x-alert type="error" :message="$errors->first()" />
                @endif
                
                @yield('content')
            </main>
        </div>
        
        <!-- Sidebar -->
        <x-admin-sidebar />
    </div>
    
    @stack('scripts')
</body>
</html>
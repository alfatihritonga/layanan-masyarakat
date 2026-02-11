<div class="drawer-side border-r border-base-content/20">
    <label for="sidebar-toggle" class="drawer-overlay"></label>
    <aside class="menu p-4 w-64 min-h-full bg-base-200">
        <div class="px-2.5 py-2 bg-base-100 w-full rounded-box text-sm flex gap-3 items-center mb-4">
            <span class="flex flex-col">
                <span class="font-semibold">
                    SIGAP BENCANA
                </span>
                <span class="text-gray-500 text-xs dark:text-gray-400">
                    Sistem Tanggap Bencana
                </span>
            </span>
        </div>
        
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="size-4">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15.75 15 10m-3 5.75H3.542m8.458 0h8.459m-16.917 0a9.2 9.2 0 0 0 1.917 2.79 9.25 9.25 0 0 0 13.082 0 9.2 9.2 0 0 0 1.918-2.79m-16.917 0A9.25 9.25 0 0 1 5.459 5.46a9.25 9.25 0 0 1 13.082 0 9.25 9.25 0 0 1 1.918 10.29"></path>
                    </svg>
                    Dashboard
                </a>
            </li>
            
            <li class="menu-title">Menu</li>

            <li>
                <a href="{{ route('reports.index') }}" class="{{ Route::is('reports.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="size-4">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 18.25v2a1 1 0 0 1-1 1H5.75a1 1 0 0 1-1-1V6.75a1 1 0 0 1 1-1h2m7.5-3h-6.5a1 1 0 0 0-1 1v13.5a1 1 0 0 0 1 1h10.5a1 1 0 0 0 1-1v-9.5m-5-5 5 5m-5-5v4a1 1 0 0 0 1 1h4"></path>
                    </svg>
                    Laporan Bencana
                </a>
            </li>

            <li class="menu-title">Master Data</li>

            <li>
                <a href="{{ route('relawan.index') }}" class="{{ Route::is('relawan.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" class="size-4">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2.75a3.5 3.5 0 1 1 0 7m5.75 10.5h1.5c.552 0 1.008-.45.921-.996-.404-2.55-2.323-4.825-4.921-5.745m-9-3.759a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7m-8.173 9.472c.552-3.553 4-6.472 8.173-6.472 4.172 0 7.62 2.92 8.173 6.472.085.546-.37.997-.923.997H2c-.552 0-1.008-.45-.923-.997"></path>
                    </svg>
                    Data Relawan
                </a>
            </li>
        </ul>
    </aside>
</div>
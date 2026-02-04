<div class="drawer-side is-drawer-close:overflow-visible">
    <label for="sidebar-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-14 is-drawer-open:w-64">
        <!-- Sidebar content here -->
        <ul class="menu w-full grow">
            
            <li>
                <a href="{{ route('user.dashboard') }}" class="{{ Route::is('user.dashboard') ? 'menu-active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" data-tip="Dashboard">
                    <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                    </svg>
                    <span class="is-drawer-close:hidden">Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('user.laporan.index') }}" class="{{ Route::is('user.laporan.index') ? 'menu-active' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right" data-tip="Laporan Bencana">
                    <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                    </svg>
                    <span class="is-drawer-close:hidden">Laporan Bencana</span>
                </a>
            </li>

        </ul>
    </div>
</div>

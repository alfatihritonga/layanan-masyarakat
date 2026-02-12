<div class="navbar w-full bg-base-300 shadow-sm">
    <!-- Mobile Menu Toggle -->
    <div class="flex-none lg:hidden">
        <label for="mobile-drawer" class="btn btn-square btn-ghost">
            <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
        </label>
    </div>
    
    <!-- Brand -->
    <div class="flex-1">
        <a href="#" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-primary/80">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.356 3.066a1 1 0 0 0-.712 0l-7 2.666A1 1 0 0 0 4 6.68a17.695 17.695 0 0 0 2.022 7.98 17.405 17.405 0 0 0 5.403 6.158 1 1 0 0 0 1.15 0 17.406 17.406 0 0 0 5.402-6.157A17.694 17.694 0 0 0 20 6.68a1 1 0 0 0-.644-.949l-7-2.666Z"/>
                </svg>
            </div>
            <div class="hidden sm:block">
                <span class="font-bold tracking-wide text-sm sm:text-base">SIGAP BENCANA</span>
                <span class="block text-xs font-medium -mt-1 opacity-60">Sistem Informasi Tanggap Bencana</span>
            </div>
        </a>
    </div>
    
    <!-- Desktop Menu -->
    <div class="flex-none hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li>
                <a href="{{ route('user.reports.index') }}" class="{{ request()->routeIs('user.reports.index') ? 'active' : '' }}">
                    Laporan Saya
                </a>
            </li>
            <li>
                <a href="{{ route('user.reports.create') }}" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Laporan
                </a>
            </li>
        </ul>
    </div>
    
    <!-- User Dropdown -->
    <div class="flex items-center gap-2">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-sm btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" />
                    @else
                        <div class="bg-neutral-900 text-neutral-content flex items-center justify-center w-full h-full rounded-full">
                            <span class="text-xs font-semibold">
                                {{ auth()->user()->initials() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div tabindex="0" class="dropdown-content z-50 mt-3 min-w-56 rounded-lg bg-neutral-900 text-neutral-content shadow-xl border border-neutral-800">
                <div class="px-3 py-2 border-b border-neutral-800">
                    <p class="font-semibold text-base leading-tight">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-sm text-neutral-400 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                
                <div class="p-1">
                    <a href="{{ route('user.reports.index') }}" class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-neutral-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan Saya
                    </a>
                    <a href="{{ route('user.reports.create') }}" class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-neutral-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Laporan
                    </a>
                </div>
                
                <div class="border-t border-neutral-800 p-1">
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-neutral-700 transition">
                            <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Drawer Menu -->
<div class="drawer lg:hidden">
    <input id="mobile-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side z-50">
        <label for="mobile-drawer" class="drawer-overlay"></label>
        <ul class="menu p-4 w-80 min-h-full bg-base-200">
            <li class="menu-title">
                <span>Menu</span>
            </li>
            <li>
                <a href="{{ route('user.reports.index') }}" class="{{ request()->routeIs('user.reports.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan Saya
                </a>
            </li>
            <li>
                <a href="{{ route('user.reports.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Laporan
                </a>
            </li>
        </ul>
    </div>
</div>
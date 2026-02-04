<div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-sm btn-ghost btn-circle avatar">
        <div class="w-16 rounded-full bg-neutral-900 text-neutral-content flex items-center justify-center">
            <span class="text-xs">
                {{ auth()->user()->initials() }}
            </span>
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
            <a href="#" class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-neutral-700 transition">
                <svg class="w-[18px] h-[18px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                </svg>
                Settings
            </a>
        </div>
        
        <div class="border-t border-neutral-800 p-1">
            <form method="POST" action="{{ route('logout') }}">
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
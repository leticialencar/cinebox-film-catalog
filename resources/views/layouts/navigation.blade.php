<nav x-data="{ open: false }" class="flex items-center justify-between px-10 py-5 border-b border-white/5 bg-[#0b0b1f]">

    <a href="{{ route('dashboard') }}">
        <img src="https://i.imgur.com/XPuoV4A.png" class="h-14 w-auto rounded-xl" alt="CineBox">
    </a>

    <div class="hidden sm:flex items-center gap-3">

        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg 
                    border border-white/15 text-gray-300 text-sm font-medium 
                    hover:border-[#8042e8]/50 hover:text-purple-300 
                    transition-all duration-200">
                <span class="w-6 h-6 rounded-full bg-[#8042e8]/30 flex items-center justify-center text-[10px] font-bold text-purple-300">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                {{ Auth::user()->name }}
                <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-[#13132b] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50"
                 style="display: none;">

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-4 py-3 text-sm text-gray-400 hover:text-white hover:bg-white/5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4"/>
                    </svg>
                    Perfil
                </a>

                <div class="border-t border-white/5"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-gray-400 hover:text-red-400 hover:bg-white/5 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="sm:hidden">
        <button @click="open = !open"
                class="p-2 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-white/20 transition">
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div :class="{'flex': open, 'hidden': !open}"
         class="hidden absolute top-[76px] left-0 right-0 flex-col bg-[#0f0f23] border-b border-white/5 px-6 py-4 gap-1 sm:hidden z-50">

        <div class="flex items-center gap-3 pb-4 mb-2 border-b border-white/5">
            <span class="w-8 h-8 rounded-full bg-[#8042e8]/30 flex items-center justify-center text-xs font-bold text-purple-300">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>


        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4"/>
            </svg>
            Perfil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-gray-400 hover:text-red-400 hover:bg-white/5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Sair
            </button>
        </form>
    </div>

</nav>
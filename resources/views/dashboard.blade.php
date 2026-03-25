<x-app-layout>
   <div class="min-h-screen bg-[#0f0c29] text-white">

        @php $featured = $popular[0] ?? null; @endphp

        @if($featured && !empty($featured['backdrop_path']))
            <div class="relative h-[85vh] w-full overflow-hidden">

                <img src="https://image.tmdb.org/t/p/original{{ $featured['backdrop_path'] }}"
                     class="absolute inset-0 w-full h-full object-cover object-top scale-105">

                <div class="absolute inset-0 
                    bg-gradient-to-t 
                    from-[#0f0c29] via-[#0f0c29]/80 via-40% 
                    to-transparent">
                </div>

                <div class="relative z-10 flex flex-col justify-end h-full px-8 md:px-16 pb-16 max-w-3xl">
                    <span class="uppercase text-sm tracking-widest text-purple-400 mb-4">
                        Em destaque
                    </span>

                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
                        {{ $featured['title'] }}
                    </h1>

                    <p class="text-gray-300 text-base md:text-lg mb-8 line-clamp-3">
                        {{ $featured['overview'] }}
                    </p>

                    <div class="flex gap-6">
                        <form method="POST" action="{{ route('movies.storeFromApi') }}">
                            @csrf
                            <input type="hidden" name="tmdb_id" value="{{ $featured['id'] }}">
                            <input type="hidden" name="title" value="{{ $featured['title'] }}">
                            <input type="hidden" name="release_year" value="{{ substr($featured['release_date'] ?? '',0,4) }}">
                            <input type="hidden" name="description" value="{{ $featured['overview'] }}">
                            <input type="hidden" name="poster" value="https://image.tmdb.org/t/p/w500{{ $featured['poster_path'] ?? '' }}">

                            <button class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-xl text-lg shadow-lg transition">
                                + Adicionar à coleção
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="px-6 md:px-10 mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Total na coleção</h3>
                </div>

                <p class="text-3xl font-bold mt-2">{{ $movies->count() }}</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Filmes populares hoje</h3>
                </div>

                <p class="text-3xl font-bold mt-2">{{ count($popular) }}</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Último adicionado</h3>
                </div>

                <p class="text-lg font-semibold mt-2">
                    {{ $movies->first()->title ?? 'Nenhum ainda' }}
                </p>
            </div>

        </div>


        <div class="px-6 md:px-10 mt-20 relative">
            <h2 class="text-2xl md:text-3xl font-bold mb-8">Populares no momento</h2>

            <button onclick="scrollCarousel(-1)" 
                class="absolute left-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur flex items-center justify-center hover:scale-110 transition">

                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="20" height="20" 
                    fill="currentColor" 
                    class="text-white"
                    viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
                </svg>
            </button>

            <button onclick="scrollCarousel(1)" 
                class="absolute right-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur flex items-center justify-center hover:scale-110 transition">

                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="20" height="20" 
                    fill="currentColor" 
                    class="text-white"
                    viewBox="0 0 16 16">
                    <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753"/>
                </svg>
            </button>


            <div id="carousel" class="flex gap-6 overflow-x-auto scroll-smooth no-scrollbar pb-4">

                @foreach($popular as $movie)
                    <div class="min-w-[160px] md:min-w-[180px] group relative rounded-xl overflow-hidden hover:z-10">

                        {{-- IMAGEM --}}
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-105 group-hover:brightness-75">

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 
                                    flex flex-col justify-end p-3 
                                    bg-gradient-to-t from-black via-black/70 to-transparent">

                            <h3 class="text-xs font-semibold mb-2">
                                {{ $movie['title'] }}
                            </h3>

                            <form method="POST" action="{{ route('movies.storeFromApi') }}">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <input type="hidden" name="title" value="{{ $movie['title'] }}">
                                <input type="hidden" name="release_year" value="{{ substr($movie['release_date'] ?? '',0,4) }}">
                                <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                                <input type="hidden" name="poster" value="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}">

                                <button class="w-full bg-purple-600 hover:bg-purple-700 py-1 rounded text-xs">
                                    + Adicionar
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

        <script>
            function scrollCarousel(direction) {
                const container = document.getElementById('carousel');
                const scrollAmount = 300;
                container.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        </script>

        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

    </div>
</x-app-layout>
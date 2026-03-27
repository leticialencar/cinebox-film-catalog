<x-app-layout>
    <div class="min-h-screen bg-[#0b0b1f] text-white">

        @php
            $releaseYear = $movie['release_date'] ?? null;

            $ratingFixed = isset($movie['rating'])
                ? number_format((float) $movie['rating'], 1, '.', '')
                : (isset($movie['vote_average'])
                    ? number_format((float) $movie['vote_average'], 1, '.', '')
                    : '0.0');

            $runtime = $movie['runtime'] ?? null;
            $hours   = $runtime ? intdiv($runtime, 60) : null;
            $minutes = $runtime ? $runtime % 60 : null;
        @endphp

        <div class="relative w-full h-[75vh] overflow-hidden">

            <img
                src="{{ $movie['backdrop'] ?? '' }}"
                class="absolute inset-0 w-full h-full object-cover scale-110 blur-sm opacity-40">

            <div class="absolute inset-0 bg-gradient-to-b from-[#0b0b1f]/20 via-[#0b0b1f]/80 to-[#0b0b1f]"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-end pb-16">
                <div class="flex flex-col md:flex-row gap-10 items-end">

                    <div class="w-56 md:w-72 rounded-2xl overflow-hidden shadow-2xl border border-white/10 translate-y-10">
                        <img
                            src="{{ $movie['poster'] ?? '' }}"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="max-w-2xl">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">
                            {{ $movie['title'] ?? 'Sem título' }}
                        </h1>

                        <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                            <span>{{ $ratingFixed }}/10</span>
                            <span>{{ $releaseYear ? substr($releaseYear, 0, 4) : '—' }}</span>

                            @if (!empty($runtime))
                                <span>{{ $hours }}h {{ $minutes }}min</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2">

                <h2 class="text-xl font-semibold mb-4 text-purple-400">Sinopse</h2>

                <p class="text-gray-300 leading-relaxed mb-10">
                    {{ $movie['overview'] ?? 'Sinopse não disponível.' }}
                </p>

                {{-- info cards --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-12">

                    <div class="bg-white/5 border border-white/10 p-5 rounded-xl">
                        <p class="text-gray-400 text-sm">Diretor</p>
                        <p class="font-semibold">{{ $movie['director'] ?? '—' }}</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-5 rounded-xl">
                        <p class="text-gray-400 text-sm">Roteiro</p>
                        <p class="font-semibold">{{ $movie['writer'] ?? '—' }}</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-5 rounded-xl">
                        <p class="text-gray-400 text-sm">Estúdio</p>
                        <p class="font-semibold">{{ $movie['studios'] ?? '—' }}</p>
                    </div>

                </div>

                {{-- cast --}}
                <h2 class="text-xl font-semibold mb-6 text-purple-400">
                    Elenco Principal
                </h2>

                <div class="flex gap-6 overflow-x-auto pb-6 no-scrollbar">

                    @forelse (collect($movie['credits']['cast'] ?? [])->take(10) as $actor)

                        @php
                            $actorName = $actor['name'] ?? 'Desconhecido';
                            $character = $actor['character'] ?? '—';

                            $profile = !empty($actor['profile_path'])
                                ? "https://image.tmdb.org/t/p/w185{$actor['profile_path']}"
                                : "https://via.placeholder.com/185x185?text=No+Image";
                        @endphp

                        <div class="min-w-[120px] text-center">

                            <img
                                src="{{ $profile }}"
                                class="w-24 h-24 mx-auto mb-3 rounded-full object-cover border border-white/10"
                            >

                            <p class="text-sm font-semibold">
                                {{ $actorName }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $character }}
                            </p>

                        </div>

                    @empty
                        <p class="text-gray-500">Elenco não disponível.</p>
                    @endforelse

                </div>

                {{-- trailer --}}
                @if ($trailer)
                    <h2 class="text-xl font-semibold mb-4 text-purple-400">
                        Trailer
                    </h2>

                    <div class="aspect-video w-full">
                        <iframe
                            class="w-full h-full rounded-xl"
                            src="https://www.youtube.com/embed/{{ $trailer }}"
                            allowfullscreen
                        >
                        </iframe>
                    </div>
                @endif

            </div>

            <div class="space-y-6">

                {{-- actions --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

                    <div class="space-y-4">

                    @if ($userData)

                        <form method="POST" action="{{ route('movies.toggleFavorite', $userData->id) }}">
                        @csrf
                        @method('PATCH')

                        <button
                            class="w-full py-3 rounded-2xl transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-lg
                            {{ $userData->is_favorite 
                                ? 'bg-red-600 hover:bg-red-700' 
                                : 'bg-gradient-to-r from-purple-600 to-purple-500 hover:scale-[1.02]' }}">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="{{ $userData->is_favorite ? 'white' : 'currentColor' }}">
                                <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                            </svg>

                            {{ $userData->is_favorite ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}

                        </button>
                    </form>

                        <button
                            class="w-full py-3 rounded-2xl border border-purple-500 text-purple-400 hover:bg-purple-600/20 transition-all duration-200 flex items-center justify-center gap-2 font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                            Editar detalhes
                        </button>

                            <form method="POST" action="{{ route('movies.destroy', $userData->id) }}">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="w-full py-3 rounded-2xl bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-2 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg>
                                    Remover da coleção
                                </button>
                            </form>

                        @else

                            <form method="POST" action="{{ route('movies.storeFromApi') }}">
                                @csrf

                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <input type="hidden" name="title" value="{{ $movie['title'] }}">
                                <input type="hidden" name="release_year" value="{{ substr($release, 0, 4) }}">
                                <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                                <input type="hidden" name="poster" value="{{ $movie['poster'] ?? '' }}">

                                <button class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-xl mb-3">
                                    + Adicionar à coleção
                                </button>

                                <p class="text-gray-400 text-sm mt-2 text-center">
                                    Esse filme ainda não faz parte da sua coleção.
                                    Adicione para acompanhar suas avaliações e novidades.
                                </p>
                            </form>

                        @endif

                    </div>
                </div>

                {{-- rating --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

                    <p class="text-gray-400 text-sm mb-2">
                        Sua avaliação
                    </p>

                    @if ($userData && !empty($userData->rating))

                        @php
                            $stars = round($userData->rating / 2);
                        @endphp

                        <div class="text-yellow-400 text-xl">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $stars ? '★' : '☆' }}
                            @endfor
                        </div>

                        <p class="text-sm text-gray-400 mt-2">
                            {{ $userData->rating }}/10
                        </p>

                    @else

                        <p class="text-gray-500 text-sm">
                            Ainda não avaliado
                        </p>

                    @endif

                </div>

            </div>

        </div>

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
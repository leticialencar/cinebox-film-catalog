<x-app-layout>
<div class="min-h-screen bg-[#0b0b1f] text-white">

@php
    $releaseYear = $movie['release_date'] ?? null;
    $ratingFixed = isset($movie['rating'])
        ? number_format((float)$movie['rating'], 1, '.', '')
        : (isset($movie['vote_average']) ? number_format((float)$movie['vote_average'], 1, '.', '') : '0.0');

    $runtime = $movie['runtime'] ?? null;
    $hours = $runtime ? intdiv($runtime, 60) : null;
    $minutes = $runtime ? $runtime % 60 : null;
@endphp

<div class="relative w-full h-[75vh] overflow-hidden">

    <img src="{{ $movie['backdrop'] ?? '' }}"
         class="absolute inset-0 w-full h-full object-cover scale-110 blur-sm opacity-40">

    <div class="absolute inset-0 bg-gradient-to-b from-[#0b0b1f]/20 via-[#0b0b1f]/80 to-[#0b0b1f]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-end pb-16">
        <div class="flex flex-col md:flex-row gap-10 items-end">

            <div class="w-56 md:w-72 rounded-2xl overflow-hidden shadow-2xl border border-white/10 translate-y-10">
                <img src="{{ $movie['poster'] ?? '' }}" class="w-full h-full object-cover">
            </div>

            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    {{ $movie['title'] ?? 'Sem título' }}
                </h1>

                <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                    <span>{{ $ratingFixed }}/10</span>
                    <span>{{ $releaseYear ? substr($releaseYear, 0, 4) : '—' }}</span>
                    @if(!empty($runtime))
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

        <h2 class="text-xl font-semibold mb-6 text-purple-400">Elenco Principal</h2>

        <div class="flex gap-6 overflow-x-auto pb-6 no-scrollbar">

            @forelse(collect($movie['credits']['cast'] ?? [])->take(10) as $actor)

                @php
                    $actorName = $actor['name'] ?? 'Desconhecido';
                    $character = $actor['character'] ?? '—';

                    $profile = !empty($actor['profile_path'])
                        ? "https://image.tmdb.org/t/p/w185{$actor['profile_path']}"
                        : "https://via.placeholder.com/185x185?text=No+Image";
                @endphp

                <div class="min-w-[120px] text-center">

                    <img src="{{ $profile }}"
                         class="w-24 h-24 mx-auto mb-3 rounded-full object-cover border border-white/10">

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

        @if($trailer) 
        <h2 class="text-xl font-semibold mb-4 text-purple-400">Trailer</h2> 
            <div class="aspect-video w-full"> 
                <iframe class="w-full h-full rounded-xl" src="https://www.youtube.com/embed/{{ $trailer }}" allowfullscreen> 
                </iframe> 
            </div> 
        @endif

    </div>

    <div class="space-y-6">

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

            @if($userData)
                <form method="POST" action="{{ route('movies.destroy', $userData->id) }}">
                    @csrf
                    @method('DELETE')

                    <button class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-xl mb-1 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                        Remover da coleção
                    </button>

                    <p class="text-gray-400 text-sm mt-2 text-center">
                        Esse filme já faz parte da sua coleção.
                    </p>
                </form>
            @else
                <form method="POST" action="{{ route('movies.storeFromApi') }}">
                    @csrf

                    <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                    <input type="hidden" name="title" value="{{ $movie['title'] }}">
                    <input type="hidden" name="release_year" value="{{ substr($release,0,4) }}">
                    <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                    <input type="hidden" name="poster" value="{{ $movie['poster'] ?? '' }}">

                    <button class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-xl mb-3">
                        + Adicionar à coleção
                    </button>

                    <p class="text-gray-400 text-sm mt-2 text-center">
                        Esse filme ainda não faz parte da sua coleção. Adicione para acompanhar suas avaliações e progresso.
                    </p>
                </form>
            @endif

        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

            <p class="text-gray-400 text-sm mb-2">Sua avaliação</p>

            @if($userData && !empty($userData->rating))
                @php $stars = round($userData->rating / 2); @endphp

                <div class="text-yellow-400 text-xl">
                    @for($i = 1; $i <= 5; $i++)
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
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

</div>
</x-app-layout>
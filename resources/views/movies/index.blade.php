<x-app-layout>
    <div class="p-6 text-white">
        <h1 class="text-2xl font-bold">Minha coleção de filmes</h1>

        <div class="mt-4">
            @foreach ($movies as $movie)
                <div class="mb-2">
                    {{ $movie->title }} ({{ $movie->release_year }})
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
<x-layout>
    <x-slot:heading>
        Planes Estratégicos de UPRM - Años
    </x-slot:heading>

    <div class="px-6 py-4">
        @foreach($strategicplans as $strategicplan)

{{--            Debug sp_id hasta donde llega (AQUI LLEGA) --}}
{{--            @php--}}
{{--                dd($strategicplan->sp_id);--}}
{{--            @endphp--}}

            <a href="{{ route('strategicplans.topics', ['strategicplan' => $strategicplan->sp_id]) }}" class="block px-4 py-6 border border-gray-200">
                <div class="font-bold text-blue-500 text-sm">
                    {{$strategicplan->sp_institution}}
                </div>

                <div>
                    <strong> Ver Asuntos </strong>
                </div>
            </a>

        @endforeach
    </div>

</x-layout>

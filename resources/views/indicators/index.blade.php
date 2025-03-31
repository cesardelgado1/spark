<x-layout>
    <x-slot:heading>
        Planes Estratégicos de UPRM - Indicadores del Objetivo #{{ $objective->o_num }}

        <a href="{{ route('indicators.create', $objective->o_id) }}"
           class="inline-flex items-center justify-center w-8 h-8 bg-[#1F2937] text-white rounded-full shadow hover:bg-gray-700 transition"
           title="Crear Indicador">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </a>

    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :strategicplan="$objective->goal->topic->strategicplan" :topic="$objective->goal->topic" :goal="$objective->goal" :objective="$objective" />

    <div class="px-6 py-4 max-h-auto overflow-y-auto border border-gray-300 rounded-lg shadow-md">

        @if(count($indicators) > 0)
            <div class="space-y-4">
                @foreach($indicators as $indicator)
                    <a href="#" class="block px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition">
                        <div class="font-bold text-gray-700 text-sm">
                            Indicador #{{ $indicator->i_num }}
                        </div>
                        <div class="text-gray-500">
                            {{ $indicator->i_prompt }}
                        </div>
                    </a>
                @endforeach

            </div>
        @else
            <p class="text-gray-500">No hay indicadores relacionados con este objetivo.</p>
        @endif

    </div>
</x-layout>

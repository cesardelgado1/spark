<x-layout>
    <x-slot:heading>
        Planes Estratégicos de UPRM - Indicadores del Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :topic="$objective->goal->topic" :goal="$objective->goal" :objective="$objective" />

    <div class="px-6 py-4">

        @if(count($indicators) > 0)
            <div class="space-y-4">
                @foreach($indicators as $indicator)
                    <a href="#" class="block px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition">
                        <div class="font-bold text-gray-700 text-sm">
                            Indicador #{{ $indicator->i_num }}
                        </div>
                        <div class="text-gray-500">
                            {{ $indicator->i_text }}
                        </div>
                        <div class="text-blue-500 mt-2">Ver más detalles</div>
                    </a>
                @endforeach

            </div>
        @else
            <p class="text-gray-500">No hay indicadores relacionados con este objetivo.</p>
        @endif

    </div>
</x-layout>

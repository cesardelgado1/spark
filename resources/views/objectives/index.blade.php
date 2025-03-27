<x-layout>
    <x-slot:heading>
        Planes Estratégicos de UPRM - Objetivos de la Meta #{{ $goal->g_num }}
    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :topic="$goal->topic" :goal="$goal" />

    <div class="px-6 py-4">
        @if(count($objectives) > 0)
            <div class="space-y-4">
                @foreach($objectives as $objective)
                    <a href="{{ route('objectives.indicators', ['objective' => $objective->o_id]) }}" class="block px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition">
                        <div class="font-bold text-gray-700 text-sm">
                            Objetivo #{{ $objective->o_num }}
                        </div>
                        <div class="text-gray-500">
                            {{ $objective->o_text }}
                        </div>
                        <div class="text-blue-500 mt-2">Ver más detalles</div>
                    </a>
                @endforeach
            </div>

        @else
            <p class="text-gray-500">No hay objetivos relacionados con esta meta.</p>
        @endif

    </div>
</x-layout>

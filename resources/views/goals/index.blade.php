<x-layout>
    <x-slot:heading>
        Planes Estratégicos de UPRM - Metas del Asunto #{{ $topic->t_num }}
    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :topic="$topic" />

    <div class="px-6 py-4">
        @if(count($goals) > 0)

            <div class="space-y-4">
                @foreach($goals as $goal)
                    <a href="{{ route('goals.objectives', ['goal' => $goal->g_id]) }}" class="block px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition">
                        <div class="font-bold text-gray-700 text-sm">
                            Meta #{{ $goal->g_num }}
                        </div>
                        <div class="text-gray-500">
                            {{ $goal->g_text }}
                        </div>
                        <div class="text-blue-500 mt-2">Ver Objetivos</div>
                    </a>
                @endforeach
            </div>

        @else
            <p class="text-gray-500">No hay metas relacionadas con este asunto.</p>
        @endif

    </div>
</x-layout>

<x-layout>

    <x-slot:heading>
        <div class="flex justify-between items-center">
            Planes Estratégicos de UPRM - Asuntos del {{ $strategicplan->sp_institution }}

            <a href="{{ route('topics.create', $strategicplan) }}"
               class="inline-flex items-center justify-center w-8 h-8 bg-[#1F2937] text-white rounded-full shadow hover:bg-gray-700 transition"
               title="Crear Asunto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>

        </div>
    </x-slot:heading>

    <div class="px-6 py-4">

{{--                    Debug sp_id hasta donde llega (AQUI LLEGA) --}}
{{--        @php--}}
{{--            dd($strategicplan->sp_id);--}}
{{--        @endphp--}}

        @if(count($topics) > 0)
            <div class="space-y-4">
                @foreach($topics as $topic)
                    <a href="{{ route('topics.goals', ['topic' => $topic->t_id]) }}" class="block px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition">
                        <div class="font-bold text-gray-700 text-sm">
                            Asunto #{{ $topic->t_num }}
                        </div>
                        <div class="text-gray-500">
                            {{ $topic->t_text }}
                        </div>
                        <div class="text-blue-500 mt-2">Ver Metas</div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No hay asuntos relacionados con este plan estratégico.</p>
        @endif
    </div>
</x-layout>

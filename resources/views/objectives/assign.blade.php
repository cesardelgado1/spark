<x-layout>
    <x-slot:heading>
        Asignar Objetivos a Contribuidores - Meta #{{ $goal->g_num }}
    </x-slot:heading>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form action="{{ route('assignobjectives.store') }}" method="POST">
            @csrf

            {{-- Select Objective --}}
            <div class="mb-6">
                <label for="objective_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar
                    Objetivo</label>
                <select name="objective_id" id="objective_id" class="w-full border border-gray-300 rounded px-4 py-2">
                    @foreach ($objectives as $objective)
                        <option value="{{ $objective->o_id }}">
                            #{{ $objective->o_num }} - {{ Str::limit($objective->o_text, 60) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Select Contributors --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Contribuidores</label>
                <div class="space-y-2 max-h-64 overflow-y-auto border p-3 rounded">
                    @foreach ($contributors as $contributor)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="user_ids[]" value="{{ $contributor->id }}"
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span>{{ $contributor->u_fname }} {{ $contributor->u_lname }} ({{ $contributor->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>
            {{--        <div class="flex justify-end gap-3">--}}
            {{--            <a href="{{ route('topics.index', ['strategicplan' => $topic->sp_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">--}}
            {{--                Cancelar--}}
            {{--            </a>--}}
            {{--            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">--}}
            {{--                Guardar Cambios--}}
            {{--            </button>--}}
            {{--        </div>--}}
            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('goals.objectives', ['goal' => $goal->g_id])  }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Asignar Objetivo
                </button>
            </div>
        </form>
    </div>
</x-layout>

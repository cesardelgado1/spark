<x-layout>
    <x-slot:heading>
        Asignar Objetivo a Asignados - Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form action="{{ route('assignments.assign', $objective->o_id) }}" method="POST">
            @csrf

            {{-- Objective (read only) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Objetivo</label>
                <input type="text" readonly value="#{{ $objective->o_num }} - {{ Str::limit($objective->o_text, 80) }}"
                       class="w-full bg-gray-100 border border-gray-300 rounded px-4 py-2">
            </div>

            {{-- Select Assignees --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Asignados</label>
                <div class="space-y-2 max-h-64 overflow-y-auto border p-3 rounded">
                    @foreach ($assignees as $assignee)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="user_ids[]" value="{{ $assignee->id }}"
                                   class="text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span>{{ $assignee->u_fname }} {{ $assignee->u_lname }} ({{ $assignee->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Asignar Objetivo
                </button>
            </div>
        </form>
    </div>
</x-layout>

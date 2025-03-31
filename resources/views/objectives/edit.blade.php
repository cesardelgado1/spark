<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Editar Objetivo #{{ $objective->o_num }}
        </h1>
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('objectives.update', $objective) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="o_num" class="block text-gray-700 font-bold">Número del Objetivo</label>
                <input type="text" id="o_num" name="o_num" value="{{ $objective->o_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="o_text" class="block text-gray-700 font-bold">Texto del Objectivo</label>
                <textarea id="o_text" name="o_text" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $objective->o_text }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('goals.objectives', ['goal' => $objective->g_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>

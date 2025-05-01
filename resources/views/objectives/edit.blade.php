<x-layout>
    <x-slot:heading>
        Editar Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('objectives.update', $objective) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="o_num" class="block text-gray-700 font-bold">Número del Objetivo</label>
                <input type="number" id="o_num" name="o_num" value="{{ $objective->o_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('o_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="o_text" class="block text-gray-700 font-bold">Texto del Objectivo</label>
                <textarea id="o_text" name="o_text" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $objective->o_text }}</textarea>
                @error('o_text')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
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

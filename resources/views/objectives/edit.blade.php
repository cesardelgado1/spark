<x-layout>
    {{-- Page heading showing current objective number --}}
    <x-slot:heading>
        Editar Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    {{-- Form container --}}
    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        {{-- Edit Objective Form --}}
        <form method="POST" action="{{ route('objectives.update', $objective) }}">
            @csrf
            @method('PUT')

            {{-- Objective Number Field --}}
            <div class="mb-4">
                <label for="o_num" class="block text-gray-700 font-bold">Número del Objetivo</label>
                <input
                    type="number"
                    id="o_num"
                    name="o_num"
                    value="{{ $objective->o_num }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                {{-- Validation Error for o_num --}}
                @error('o_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Objective Text Field --}}
            <div class="mb-4">
                <label for="o_text" class="block text-gray-700 font-bold">Texto del Objectivo</label>
                <textarea
                    id="o_text"
                    name="o_text"
                    rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >{{ $objective->o_text }}</textarea>
                {{-- Validation Error for o_text --}}
                @error('o_text')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons: Cancel & Submit --}}
            <div class="flex justify-end gap-3">
                {{-- Cancel button returns to the objectives list for this goal --}}
                <a href="{{ route('goals.objectives', ['goal' => $objective->g_id]) }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>

                {{-- Submit button to save the updates --}}
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>

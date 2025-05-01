<x-layout>
    <x-slot:heading>
        Crear Objetivo para la Meta: {{ $goal->g_num }}
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('objectives.store', $goal) }}" method="POST">
            @csrf
            <input type="hidden" name="g_id" value="{{ $goal->g_id }}">

            <!-- Número del Objetivo -->
            <div class="mb-4">
                <label for="o_num" class="block font-bold text-gray-700">Número del Objetivo</label>
                <input type="number" name="o_num" id="o_num" min="1" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 no-spinner">
                @error('o_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <style>
                /* Quitar flechas del input de tipo number */
                input[type="number"].no-spinner::-webkit-outer-spin-button,
                input[type="number"].no-spinner::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                input[type="number"].no-spinner {
                    -moz-appearance: textfield; /* Firefox */
                }
            </style>

            <!-- Texto del Objetivo -->
            <div class="mb-4">
                <label for="o_text" class="block font-bold text-gray-700">Descripción del Objetivo</label>
                <textarea name="o_text" id="o_text" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                @error('o_text')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('goals.objectives', $goal->g_id) }}" class="rounded-md bg-gray-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Crear
                </button>
            </div>
        </form>
    </div>
</x-layout>

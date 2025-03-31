<x-layout>
    <x-slot:heading>
        Crear Indicador para el Objetivo: {{ $objective->o_num }}
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('indicators.store', $objective) }}" method="POST">
            @csrf
            <input type="hidden" name="o_id" value="{{ $objective->o_id }}">

            <!-- Número del Indicador -->
            <div class="mb-4">
                <label for="i_num" class="block font-bold text-gray-700">Número del Indicador</label>
                <input type="number" name="i_num" id="i_num" min="1" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 no-spinner">
            </div>

            <style>
                /* Quitar flechas del input de tipo number */
                input[type="number"].no-spinner::-webkit-outer-spin-button,
                input[type="number"].no-spinner::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                input[type="number"].no-spinner {
                    -moz-appearance: textfield;
                }
            </style>

            <!-- Texto del Indicador -->
            <div class="mb-4">
                <label for="i_prompt" class="block font-bold text-gray-700">Descripción del Indicador</label>
                <textarea name="i_prompt" id="i_prompt" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <!-- Tipo del Indicador -->
            <div class="mb-4">
                <label for="i_type" class="block font-bold text-gray-700">Tipo de Indicador</label>
                <select name="i_type" id="i_type" required
                        class="w-32 px-2 py-1 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    <option value="string">string</option>
                    <option value="integer">integer</option>
                    <option value="document">document</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('objectives.indicators', $objective->o_id) }}" class="text-sm/6 font-semibold text-gray-900">Cancelar</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-layout>

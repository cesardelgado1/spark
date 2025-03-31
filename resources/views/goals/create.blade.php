<x-layout>
    <x-slot:heading>
        Crear Meta para el Asunto: {{ $topic->t_num }}
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('goals.store', $topic->t_id) }}" method="POST">
            @csrf
            <input type="hidden" name="t_id" value="{{ $topic->t_id }}">

            <!-- Número de la Meta -->
            <div>
                <label for="g_num" class="block font-bold text-gray-700">Número de la Meta</label>
                <input type="number" name="g_num" id="g_num" min="1" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 no-spinner">
            </div>

            <!-- Quitar spinner con CSS -->
            <style>
                input[type="number"].no-spinner::-webkit-outer-spin-button,
                input[type="number"].no-spinner::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                input[type="number"].no-spinner {
                    -moz-appearance: textfield;
                }
            </style>

            <!-- Texto de la Meta -->
            <div class="mt-4">
                <label for="g_text" class="block font-bold text-gray-700">Descripción de la Meta</label>
                <textarea name="g_text" id="g_text" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <!-- Botón para Crear -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('topics.goals', $topic->t_id) }}" class="text-sm/6 font-semibold text-gray-900">Cancelar</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
            </div>
        </form>
    </div>
</x-layout>

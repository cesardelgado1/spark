<x-layout>
    <x-slot:heading>
        Crear Asunto para el Plan Estratégico: {{ $strategicplan->sp_institution }}
    </x-slot:heading>

    {{-- Debug sp_id hasta donde llega (NO LLEGA AQUI), nada relacionado el sp no llega--}}
{{--    @php--}}
{{--        dd($strategicplan->sp_id);--}}
{{--    @endphp--}}

    <div class="px-6 py-4">
        <form action="{{ route('topics.store', $strategicplan) }}" method="POST">
            @csrf
            <input type="hidden" name="sp_id" value="{{ $strategicplan->sp_id }}">

            <!-- Número del Asunto -->
            <div>
                <label for="t_num" class="block font-bold text-gray-700">Número del Asunto</label>
                <input type="number" name="t_num" id="t_num" min="1" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 no-spinner">
                @error('t_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quitar spinner con CSS -->
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

            <!-- Texto del Asunto -->
            <div>
                <label for="t_text" class="block font-bold text-gray-700">Descripción del Asunto</label>
                <textarea name="t_text" id="t_text" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                @error('t_text')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón para Crear -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('strategicplans.topics', $strategicplan->sp_id) }}" class="text-sm/6 font-semibold text-gray-900">Cancelar</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear</button>
            </div>
        </form>
    </div>
</x-layout>

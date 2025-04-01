<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Editar Indicador #{{ $indicator->i_num }}
        </h1>
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('indicators.update', $indicator) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="o_id" value="{{ $indicator->o_id }}">

            <div class="mb-4">
                <label for="i_num" class="block text-gray-700 font-bold">Número del Indicador</label>
                <input type="text" id="i_num" name="i_num" value="{{ $indicator->i_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="i_text" class="block text-gray-700 font-bold">Texto del Indicador</label>
                <textarea id="i_text" name="i_text" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $indicator->i_text }}</textarea>
            </div>

            <div class="mb-4">
                <label for="i_type" class="block font-bold text-gray-700">Tipo de Indicador</label>
                <select name="i_type" id="i_type" required
                        class="w-32 px-2 py-1 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    <option value="string">Texto</option>
                    <option value="integer">Número</option>
                    <option value="document">Documento</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('objectives.indicators', ['objective' => $indicator->o_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>

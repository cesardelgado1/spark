<x-layout>
    <x-slot:heading>
        Editar Plan Estratégico
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('strategicplans.update', $strategicplan->sp_id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="sp_institution" class="block text-gray-700 font-bold">Año del Plan Estratégico</label>
                <input type="text" id="sp_institution" name="sp_institution" value="{{ old('sp_institution', $strategicplan->sp_institution) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('sp_institution')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('strategicplans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>

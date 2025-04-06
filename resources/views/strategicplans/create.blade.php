<x-layout>
    <x-slot:heading>
        Crear Plan Estratégico
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('strategicplans.store') }}" method="POST">
            @csrf

            <!-- Nombre o descripción del plan -->
            <div class="mb-4">
                <label for="sp_institution" class="block font-bold text-gray-700">Año del Plan Estratégico</label>
                <input type="text" name="sp_institution" id="sp_institution" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                       value="{{ old('sp_institution') }}">
                @error('sp_institution')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('strategicplans.index') }}" class="text-sm font-semibold text-gray-900">Cancelar</a>
                <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-layout>

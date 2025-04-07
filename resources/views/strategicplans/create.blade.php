<x-layout>
    <x-slot:heading>
        Crear Plan Estratégico
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('strategicplans.store') }}" method="POST">
            @csrf

            <!-- Hidden field for Institution -->
            <input type="hidden" name="sp_institution" value="{{ $institution }}">

            <!-- Años del Plan Estratégico -->
            <div class="mb-4">
                <div class="mb-4">
                    <label class="block font-bold text-gray-700">Seleccionar Años del Plan Estratégico</label>

                    <div class="flex gap-4">
                        <!-- Start Year -->
                        <div class="flex-1">
                            <label for="start_year" class="block text-sm text-gray-700">Año de Inicio</label>
                            <select name="start_year" id="start_year" required class="w-full px-4 py-2 border rounded-lg">
                                @for ($year = 2020; $year <= 2040; $year++)
                                    <option value="{{ $year }}" {{ old('start_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- End Year -->
                        <div class="flex-1">
                            <label for="end_year" class="block text-sm text-gray-700">Año de Fin</label>
                            <select name="end_year" id="end_year" required class="w-full px-4 py-2 border rounded-lg">
                                @for ($year = 2025; $year <= 2045; $year++)
                                    <option value="{{ $year }}" {{ old('end_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    @error('start_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @error('end_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @error('sp_years')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('strategicplans.index', ['institution' => $institution]) }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    Cancelar
                </a>
                <button type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Crear
                </button>
            </div>
        </form>
    </div>
</x-layout>

<x-layout>
    <x-slot:heading>
        Crear Indicador para el Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    <div class="px-6 py-4">
        <form action="{{ route('indicators.store', $objective->o_id) }}" method="POST">
            @csrf
            <input type="hidden" name="o_id" value="{{ $objective->o_id }}">

            <!-- Rango del Año Fiscal -->
            <div class="mb-4">
                <label class="block font-bold text-gray-700">Seleccionar Años Fiscales del Indicador</label>

                <div class="flex gap-4">
                    <!-- Año de Inicio -->
                    <div class="flex-1">
                        <label for="fy_start" class="block text-sm text-gray-700">Año de Inicio</label>
                        <select name="fy_start" id="fy_start" required class="w-full px-4 py-2 border rounded-lg">
                            @for ($year = 2020; $year <= 2100; $year++)
                                <option value="{{ $year }}" {{ old('fy_start') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Año de Fin -->
                    <div class="flex-1">
                        <label for="fy_end" class="block text-sm text-gray-700">Año de Fin</label>
                        <select name="fy_end" id="fy_end" required class="w-full px-4 py-2 border rounded-lg">
                            @for ($year = 2020; $year <= 2100; $year++)
                                <option value="{{ $year }}" {{ old('fy_end') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <p id="fy-error" class="text-red-500 text-sm mt-2 hidden">Los años fiscales deben tener una duración de un año. Verifica el año de inicio y el año de finalización.</p>

                @error('fy_start')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @error('fy_end')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Número del Indicador -->
            <div class="mb-4">
                <label for="i_num" class="block font-bold text-gray-700">Número del Indicador</label>
                <input type="number" name="i_num" id="i_num" min="1" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 no-spinner">
                @error('i_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            <!-- Descripción del Indicador -->
            <div class="mb-4">
                <label for="i_text" class="block font-bold text-gray-700">Descripción del Indicador</label>
                <textarea name="i_text" id="i_text" rows="4" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <!-- Tipo del Indicador -->
            <div class="mb-4">
                <label for="i_type" class="block font-bold text-gray-700">Tipo de Indicador</label>
                <select name="i_type" id="i_type" required
                        class="w-32 px-2 py-1 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
                    <option value="string">Texto</option>
                    <option value="integer">Número</option>
                    <option value="document">Documento</option>
                </select>
            </div>




            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('objectives.indicators', $objective->o_id) }}" class="rounded-md bg-gray-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Crear
                </button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fyStart = document.getElementById('fy_start');
                const fyEnd = document.getElementById('fy_end');
                const fyError = document.getElementById('fy-error');
                const form = document.querySelector('form');

                function validateFiscalYears() {
                    const start = parseInt(fyStart.value);
                    const end = parseInt(fyEnd.value);

                    if (end < start) {
                        fyError.classList.remove('hidden');
                        return false;
                    } else {
                        fyError.classList.add('hidden');
                        return true;
                    }
                }

                fyStart.addEventListener('change', validateFiscalYears);
                fyEnd.addEventListener('change', validateFiscalYears);

                form.addEventListener('submit', function (e) {
                    if (!validateFiscalYears()) {
                        e.preventDefault();
                    }
                });
            });
        </script>


    </div>
</x-layout>

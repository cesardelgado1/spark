<x-layout>
    <x-slot:heading>
            Editar Indicador #{{ $indicator->i_num }}
    </x-slot:heading>

    @php
        $strategicPlan = $indicator->objective->goal->topic->strategicPlan;
        $isUPRM = $strategicPlan->sp_institution === 'UPRM';

        if ($isUPRM) {
            [$startYear, $endYear] = explode('-', $strategicPlan->sp_years);
            $validYears = range((int)$startYear, (int)$endYear);
        } else {
            $validYears = range(2020, 2100);
        }
    @endphp

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('indicators.update', $indicator) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="o_id" value="{{ $indicator->o_id }}">

            <!-- Rango del Año Fiscal -->
            <div class="mb-4">
                <label class="block font-bold text-gray-700">Seleccionar Años Fiscales del Indicador</label>

                <div class="flex gap-4">
                    <!-- Año de Inicio -->
                    <div class="flex-1">
                        <label for="fy_start" class="block text-sm text-gray-700">Año de Inicio</label>
                        <select name="fy_start" id="fy_start" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">--Selecciona año de inicio--</option>
                            @foreach ($validYears as $year)
                                <option value="{{ $year }}" {{ (explode('-', $indicator->i_FY)[0] ?? '') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Año de Fin -->
                    <div class="flex-1">
                        <label for="fy_end" class="block text-sm text-gray-700">Año de Fin</label>
                        <select name="fy_end" id="fy_end" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">--Selecciona año de fin--</option>
                            @foreach ($validYears as $year)
                                <option value="{{ $year }}" {{ (explode('-', $indicator->i_FY)[1] ?? '') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Mensaje de error y validaciones -->
                @if ($isUPRM)
                    <p id="fy-error" class="text-red-500 text-sm mt-2 hidden">
                        Los años fiscales deben ser consecutivos (ej. 2025-2026, 2026-2027). Verifica el año de inicio y finalización.
                    </p>
                @endif


                @error('fy_start')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @error('fy_end')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="i_num" class="block text-gray-700 font-bold">Número del Indicador</label>
                <input type="number" id="i_num" name="i_num" value="{{ $indicator->i_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('i_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const fyStart = document.getElementById('fy_start');
            const fyEnd = document.getElementById('fy_end');
            const fyError = document.getElementById('fy-error');
            const form = document.querySelector('form');

            function validateFiscalYears() {

                const start = parseInt(fyStart.value);
                const end = parseInt(fyEnd.value);

                if (isNaN(start) || isNaN(end) || end !== start + 1) {
                    fyError?.classList.remove('hidden');
                    return false;
                } else {
                    fyError?.classList.add('hidden');
                    return true;
                }
            }

            fyStart?.addEventListener('change', validateFiscalYears);
            fyEnd?.addEventListener('change', validateFiscalYears);

            form?.addEventListener('submit', function (e) {
                if (!validateFiscalYears()) {
                    e.preventDefault();
                }
            });
        });
    </script>


</x-layout>

<x-layout>
    <x-slot:heading>
        Editar Plan Estratégico
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('strategicplans.update', $strategicplan->sp_id) }}" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Años del Plan Estratégico</label>

                <!-- Hidden input to store concatenated years -->
                <input type="hidden" id="sp_years" name="sp_years" value="{{ old('sp_years', $strategicplan->sp_years) }}">
                <input type="hidden" name="sp_institution" value="{{ $strategicplan->sp_institution }}">
                <div class="flex gap-4">
                    <!-- Start Year Dropdown -->
                    <div>
                        <label for="start_year" class="block text-sm text-gray-700">Año Inicio</label>
                        <select id="start_year" class="w-full px-4 py-2 border rounded-lg" onchange="updateYears()">
                            @for($year = 2020; $year <= 2050; $year++)
                                <option value="{{ $year }}" {{ (explode('-', $strategicplan->sp_years)[0] ?? '') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- End Year Dropdown -->
                    <div>
                        <label for="end_year" class="block text-sm text-gray-700">Año Fin</label>
                        <select id="end_year" class="w-full px-4 py-2 border rounded-lg" onchange="updateYears()">
                            @for($year = 2025; $year <= 2060; $year++)
                                <option value="{{ $year }}" {{ (explode('-', $strategicplan->sp_years)[1] ?? '') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <p id="year-error" class="text-red-500 text-sm mt-2"></p>

                @error('sp_years')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('strategicplans.index', ['institution' => $strategicplan->sp_institution]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
        <div id="year-error-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                <h2 class="text-lg font-bold text-red-600 mb-4">¡Error de Rango de Años!</h2>
                <p class="text-gray-700 mb-4">El año de fin debe ser mayor que el año de inicio.</p>
                <div class="flex justify-end gap-3">
                    <button onclick="closeYearErrorModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-layout>

<!-- Script to combine years -->
<script>
    function updateYears() {
        const startYear = parseInt(document.getElementById('start_year').value);
        const endYear = parseInt(document.getElementById('end_year').value);
        const errorContainer = document.getElementById('year-error');

        if (startYear > endYear || (startYear === endYear)) {
            errorContainer.innerText = 'El plan estratégico debe tener un rango válido de años.';
        } else {
            errorContainer.innerText = '';
            document.getElementById('sp_years').value = `${startYear}-${endYear}`;
        }
    }

    function openYearErrorModal() {
        document.getElementById('year-error-modal').classList.remove('hidden');
    }

    function closeYearErrorModal() {
        document.getElementById('year-error-modal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', updateYears);

    function validateForm() {
        const startYear = parseInt(document.getElementById('start_year').value);
        const endYear = parseInt(document.getElementById('end_year').value);
        const errorContainer = document.getElementById('year-error');

        if (startYear > endYear || (startYear === endYear)) {
            errorContainer.innerText = 'El plan estratégico debe tener un rango válido de años.';
            return false; // bloquear envío
        }

        return true;
    }
</script>

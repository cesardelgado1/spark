<x-layout>
    <x-slot:heading>
        Llenar Indicadores para Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    <div class="px-6">
        <form method="POST" action="{{ route('indicators.updateValues') }}"
              class="bg-white border border-gray-300 rounded-lg shadow-md p-6 space-y-6 max-w-4xl mx-auto">
            @csrf

            <input type="hidden" name="objective_id" value="{{ $objective->o_id }}">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Entrar valores de indicadores
            </h2>

            @foreach($indicators as $index => $indicator)
                <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        Indicador #{{ $indicator->i_num }}
                    </h3>

                    <p class="text-gray-700 mb-3">
                        {{ $indicator->i_text }}
                    </p>

                    <input type="text"
                           name="indicators[{{ $indicator->i_id }}]"
                           id="indicator_{{ $indicator->i_id }}"
                           value="{{ old("indicators.{$indicator->i_id}", $indicator->i_value) }}"
                           placeholder="Ingrese el valor del indicador"
                           class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">
                </div>
            @endforeach

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Guardar Valores
                </button>
            </div>
        </form>
    </div>
</x-layout>

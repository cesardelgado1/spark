{{--<x-layout>--}}
{{--    <x-slot:heading>--}}
{{--        Llenar Indicadores para Objetivo #{{ $objective->o_num }}--}}
{{--    </x-slot:heading>--}}

{{--    <div class="px-6">--}}
{{--        <form method="POST" action="{{ route('indicators.updateValues') }}" enctype="multipart/form-data"--}}
{{--              class="bg-white border border-gray-300 rounded-lg shadow-md p-6 space-y-6 max-w-4xl mx-auto">--}}
{{--            @csrf--}}

{{--            <input type="hidden" name="objective_id" value="{{ $objective->o_id }}">--}}

{{--            <h2 class="text-xl font-semibold text-gray-800 mb-6">--}}
{{--                Entrar valores de indicadores--}}
{{--            </h2>--}}

{{--            @foreach($indicators as $indicator)--}}
{{--                <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">--}}
{{--                    <h3 class="text-lg font-semibold text-gray-800 mb-1">--}}
{{--                        Indicador #{{ $indicator->i_num }}--}}
{{--                    </h3>--}}

{{--                    <p class="text-gray-700 mb-3">--}}
{{--                        {{ $indicator->i_text }}--}}
{{--                    </p>--}}

{{--                    @if ($indicator->i_type === 'integer')--}}
{{--                        <input type="number"--}}
{{--                               name="indicators[{{ $indicator->i_id }}]"--}}
{{--                               id="indicator_{{ $indicator->i_id }}"--}}
{{--                               value="{{ old("indicators.{$indicator->i_id}", $indicator->i_value) }}"--}}
{{--                               placeholder="Ingrese un número entero"--}}
{{--                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">--}}
{{--                    @elseif ($indicator->i_type === 'string')--}}
{{--                        <input type="text"--}}
{{--                               name="indicators[{{ $indicator->i_id }}]"--}}
{{--                               id="indicator_{{ $indicator->i_id }}"--}}
{{--                               value="{{ old("indicators.{$indicator->i_id}", $indicator->i_value) }}"--}}
{{--                               placeholder="Ingrese un texto"--}}
{{--                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">--}}
{{--                    @elseif ($indicator->i_type === 'document')--}}
{{--                        @if ($indicator->i_value)--}}
{{--                            <p class="text-sm text-blue-600 mb-2">Documento actual:--}}
{{--                                <a href="{{ Storage::url($indicator->i_value) }}" target="_blank" class="underline">--}}
{{--                                    Ver Documento--}}
{{--                                </a>--}}
{{--                            </p>--}}
{{--                        @endif--}}
{{--                        <input type="file"--}}
{{--                               name="indicators[{{ $indicator->i_id }}]"--}}
{{--                               id="indicator_{{ $indicator->i_id }}"--}}
{{--                               accept=".pdf,.doc,.docx"--}}
{{--                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endforeach--}}

{{--            <div class="flex justify-end gap-3 pt-4 border-t">--}}
{{--                <a href="{{ route('tasks.index') }}"--}}
{{--                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">--}}
{{--                    Cancelar--}}
{{--                </a>--}}
{{--                <button type="submit"--}}
{{--                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">--}}
{{--                    Guardar Valores--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    --}}{{-- Modal --}}
{{--    <div id="error-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">--}}
{{--        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">--}}
{{--            <h2 class="text-lg font-bold mb-4 text-red-600">Error de Validación</h2>--}}
{{--            <p class="text-gray-700 mb-4">Por favor, verifica que los datos ingresados correspondan al tipo requerido.</p>--}}
{{--            <div class="flex justify-end">--}}
{{--                <button onclick="closeModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">--}}
{{--                    Cerrar--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        function closeModal() {--}}
{{--            document.getElementById('error-modal').classList.add('hidden');--}}
{{--        }--}}

{{--        document.querySelector('form').addEventListener('submit', function (e) {--}}
{{--            let valid = true;--}}

{{--            @foreach($indicators as $indicator)--}}
{{--            let input = document.getElementById('indicator_{{ $indicator->i_id }}');--}}

{{--            @if ($indicator->i_type === 'integer')--}}
{{--            if (input && input.value && isNaN(input.value)) {--}}
{{--                valid = false;--}}
{{--            }--}}
{{--            @elseif ($indicator->i_type === 'document')--}}
{{--            if (input && input.files.length > 0) {--}}
{{--                const allowedExtensions = ['pdf', 'doc', 'docx'];--}}
{{--                const fileName = input.files[0].name.toLowerCase();--}}
{{--                const extension = fileName.split('.').pop();--}}
{{--                if (!allowedExtensions.includes(extension)) {--}}
{{--                    valid = false;--}}
{{--                }--}}
{{--            }--}}
{{--            @endif--}}
{{--                @endforeach--}}

{{--            if (!valid) {--}}
{{--                e.preventDefault();--}}
{{--                document.getElementById('error-modal').classList.remove('hidden');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--</x-layout>--}}


<x-layout>
    <x-slot:heading>
        Llenar Indicadores para Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    <div class="px-6">
        <form method="POST" action="{{ route('indicators.updateValues') }}" enctype="multipart/form-data"
              class="bg-white border border-gray-300 rounded-lg shadow-md p-6 space-y-6 max-w-4xl mx-auto">
            @csrf

            <input type="hidden" name="objective_id" value="{{ $objective->o_id }}">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                Entrar valores de indicadores
            </h2>

            @foreach($indicators as $indicator)
                <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        Indicador #{{ $indicator->i_num }}
                    </h3>

                    <p class="text-gray-700 mb-3">
                        {{ $indicator->i_text }}
                    </p>

                    @if ($indicator->i_type === 'integer')
                        <input type="number"
                               name="indicators[{{ $indicator->i_id }}]"
                               id="indicator_{{ $indicator->i_id }}"
                               value="{{ old("indicators.{$indicator->i_id}", $indicator->user_value) }}"
                               placeholder="Ingrese un número entero"
                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">
                    @elseif ($indicator->i_type === 'string')
                        <input type="text"
                               name="indicators[{{ $indicator->i_id }}]"
                               id="indicator_{{ $indicator->i_id }}"
                               value="{{ old("indicators.{$indicator->i_id}", $indicator->user_value) }}"
                               placeholder="Ingrese un texto"
                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">
                    @elseif ($indicator->i_type === 'document')
                        @if ($indicator->user_value)
                            <p class="text-sm text-blue-600 mb-2">Documento actual:
{{--                                <a href="{{ Storage::url($indicator->user_value) }}" target="_blank" class="underline">--}}
{{--                                    Ver Documento--}}
{{--                                </a>--}}
                                <a href="{{ Storage::url('documents/' . $indicator->user_value) }}" target="_blank" class="underline">
                                    Ver Documento
                                </a>

                            </p>
                        @endif
                        <input type="file"
                               name="indicators[{{ $indicator->i_id }}]"
                               id="indicator_{{ $indicator->i_id }}"
                               accept=".pdf,.doc,.docx"
                               class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">
                    @endif
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

    {{-- Modal --}}
    <div id="error-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-bold mb-4 text-red-600">Error de Validación</h2>
            <p class="text-gray-700 mb-4">Por favor, verifica que los datos ingresados correspondan al tipo requerido.</p>
            <div class="flex justify-end">
                <button onclick="closeModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('error-modal').classList.add('hidden');
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            let valid = true;

            @foreach($indicators as $indicator)
            let input = document.getElementById('indicator_{{ $indicator->i_id }}');

            @if ($indicator->i_type === 'integer')
            if (input && input.value && isNaN(input.value)) {
                valid = false;
            }
            @elseif ($indicator->i_type === 'document')
            if (input && input.files.length > 0) {
                const allowedExtensions = ['pdf', 'doc', 'docx'];
                const fileName = input.files[0].name.toLowerCase();
                const extension = fileName.split('.').pop();
                if (!allowedExtensions.includes(extension)) {
                    valid = false;
                }
            }
            @endif
                @endforeach

            if (!valid) {
                e.preventDefault();
                document.getElementById('error-modal').classList.remove('hidden');
            }
        });
    </script>
</x-layout>

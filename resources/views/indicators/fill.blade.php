<x-layout>
    <x-slot:heading>
        Llenar Indicadores para Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    <div class="px-6">
        @if($indicators->isEmpty())
            <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded shadow">
                <p class="font-semibold">Actualmente no hay indicadores disponibles para este objetivo en este año fiscal.</p>
            </div>
        @endif

        @if(!$indicators->isEmpty())
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

                        <p class="text-gray-700 mb-2">
                            {{ $indicator->i_text }}
                        </p>

                        @if($indicator->i_locked)
                            <p class="text-red-500 font-bold text-sm mb-2">🔒 Este indicador ha sido cerrado. No puedes modificarlo.</p>
                        @endif

                        @if ($indicator->i_type === 'integer')
                            <input type="number"
                                   name="indicators[{{ $indicator->i_id }}]"
                                   id="indicator_{{ $indicator->i_id }}"
                                   value="{{ old("indicators.{$indicator->i_id}", $indicator->user_value) }}"
                                   placeholder="Ingrese un número entero"
                                   class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none"
                                   @if($indicator->i_locked) disabled @endif>
                        @elseif ($indicator->i_type === 'string')
                            <div class="relative group">
                                <textarea
                                    name="indicators[{{ $indicator->i_id }}]"
                                    id="indicator_{{ $indicator->i_id }}"
                                    data-expanded="false"
                                    placeholder="Ingrese un texto"
                                    rows="1"
                                    class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none resize-none overflow-hidden auto-grow"
                                    @if($indicator->i_locked) disabled @endif
                                >{{ old("indicators.{$indicator->i_id}", $indicator->user_value) }}</textarea>

                                <button
                                    type="button"
                                    class="absolute right-2 top-2 text-gray-500 hover:text-gray-800 hidden group-hover:block z-10"
                                    onclick="toggleExpandTextarea(this, 'indicator_{{ $indicator->i_id }}')"
                                    title="Expandir texto"
                                >
                                    {{-- Down Arrow (show when collapsed) --}}
                                    <svg class="w-8 h-8 expand-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>

                                    {{-- Up Arrow (show when expanded) --}}
                                    <svg class="w-8 h-8 collapse-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>

                            </div>


                        @elseif ($indicator->i_type === 'document')
                            @if ($indicator->user_value)
                                <p class="text-sm text-blue-600 mb-2">Documento actual:
                                    <a href="{{ Storage::url('documents/' . $indicator->user_value) }}" target="_blank" class="underline">
                                        Ver Documento
                                    </a>
                                </p>
                            @endif

                            @if(!$indicator->i_locked)
                                <input type="file"
                                       name="indicators[{{ $indicator->i_id }}]"
                                       id="indicator_{{ $indicator->i_id }}"
                                       accept=".pdf,.doc,.docx"
                                       class="w-full border px-4 py-2 rounded-lg focus:ring-indigo-500 focus:outline-none">
                            @else
                                <p class="text-gray-500 text-sm italic">Subida de documentos bloqueada.</p>
                            @endif
                        @endif
                    </div>
                @endforeach

                @php
                    $hasUnlocked = $indicators->contains(fn($indicator) => !$indicator->i_locked);
                @endphp

                @if($hasUnlocked)
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('tasks.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                            Cancelar
                        </a>
                        <button type="submit"
                                id="submit-button"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Guardar Valores
                        </button>
                    </div>
                @else
                    <div class="text-center text-gray-500 italic mt-6">
                        Todos los indicadores han sido cerrados. No puedes guardar cambios.
                    </div>
                @endif
            </form>
        @endif
    </div>

{{--     Modal for Error--}}
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

{{--     Scripts--}}
    <script>
        function closeModal() {
            document.getElementById('error-modal').classList.add('hidden');
        }

        function autoGrow(element) {
            element.style.height = "auto";
            element.style.height = (element.scrollHeight) + "px";
        }

        document.querySelector('form')?.addEventListener('submit', function (e) {
            let valid = true;

            @foreach($indicators as $indicator)
            @if(!$indicator->i_locked)
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
                @endif
                @endforeach

            if (!valid) {
                e.preventDefault();
                document.getElementById('error-modal').classList.remove('hidden');
            } else {
                const submitButton = document.getElementById('submit-button');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                    submitButton.innerText = 'Guardando...';
                }
            }
        });

        // Trigger auto-grow on load for any pre-filled textareas
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('textarea').forEach(el => autoGrow(el));
        });

    </script>

    <script>
        function autoGrow(el) {
            el.style.height = "auto";
            el.style.height = el.scrollHeight + "px";
        }

        function toggleExpandTextarea(button, textareaId) {
            const textarea = document.getElementById(textareaId);
            const expandIcon = button.querySelector('.expand-icon');
            const collapseIcon = button.querySelector('.collapse-icon');

            if (!textarea) return;

            const isExpanded = textarea.dataset.expanded === 'true';

            if (isExpanded) {
                textarea.dataset.expanded = 'false';
                textarea.rows = 1;
                textarea.style.height = ""; // remove inline height
                expandIcon.classList.remove('hidden');
                collapseIcon.classList.add('hidden');
            } else {
                textarea.dataset.expanded = 'true';
                textarea.style.height = "auto";
                textarea.style.height = textarea.scrollHeight + "px";
                expandIcon.classList.add('hidden');
                collapseIcon.classList.remove('hidden');
            }
        }
    </script>





</x-layout>


<x-layout>
    <x-slot:heading>
        Plan Estratégico {{$objective->goal->topic->strategicplan->sp_institution}} : Indicadores del Objetivo #{{ $objective->o_num }}

        <a href="{{ route('indicators.create', $objective->o_id) }}"
           class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow hover:bg-blue-500 transition"
           title="Crear Indicador">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </a>
        <button onclick="toggleIndicatorCheckboxes()" class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow hover:bg-red-700 transition"
                title="Eliminar Indicadores">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>

        <button onclick="enterIndicatorEditMode()" class="inline-flex items-center justify-center w-8 h-8 bg-[#ff9800] text-white rounded-full shadow hover:bg-[#ff9800] transition"
                title="Editar Objetivos">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </button>
    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :strategicplan="$objective->goal->topic->strategicplan" :topic="$objective->goal->topic" :goal="$objective->goal" :objective="$objective" />

    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div id="indicator-edit-mode-banner" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-2" role="alert">
        <strong class="font-bold">¡Modo Edición Activado!</strong>
        <span class="inline-block sm:inline">Haz clic en un indicador para editarlo.</span>

        <span onclick="cancelIndicatorEdit()" class="ml-2 cursor-pointer underline hover:text-red-700">
        Cancelar
    </span>
    </div>
    {{-- NEW: Fiscal Year Tabs --}}
    @if(count($fiscalYears) > 0)
        <div class="flex space-x-2 mb-4">
            @foreach($fiscalYears as $fy)
                <button onclick="showFiscalYear('{{ $fy }}')" id="tab-{{ $fy }}" class="mt-2 ml-6 py-2 px-4 bg-gray-700 hover:bg-gray-600 rounded ">
                    {{ $fy }}
                </button>
            @endforeach
        </div>

        {{-- Copy Fiscal Year Button --}}
        <form action="{{ route('indicators.copyFiscalYear', $objective->o_id) }}" method="POST" onsubmit="return confirmCopy()">
            @csrf
            <input type="hidden" name="current_fy" id="currentFiscalYear" value="">
            <button type="submit" class="ml-6 mb-6 py-2 px-4 bg-gray-700 text-white border border-white rounded hover:bg-gray-600 focus:outline-none">
                Copiar indicadores al próximo año fiscal
            </button>
        </form>
    @endif
    <!-- Delete Document Modal (Pop Up)-->
    <div id="deleteDocumentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">¿Estás seguro de que quieres eliminar este documento?</h2>
            <form id="deleteDocumentForm" method="POST" action="{{ route('indicators.removeDocument') }}">
                @csrf
                @method('POST')
                <input type="hidden" name="indicator_id" id="indicatorIdInput">
                <input type="hidden" name="document_name" id="documentNameInput">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Sí, Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="px-6 py-4 max-h-auto overflow-y-auto border border-gray-300 rounded-lg shadow-md">
        @if(count($indicators) > 0)
            {{-- NEW: Grouped indicators per FY --}}
            @foreach($indicators as $fy => $fyIndicators)
                <div id="fy-{{ $fy }}" class="fiscalYearSection" style="display: none;">
                    <div class="space-y-4">
                        @foreach($fyIndicators as $indicator)
                            {{-- Existing Indicator Card (UNTOUCHED) --}}
                            <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 relative group cursor-pointer hover:bg-gray-100 transition"
                                 onclick="redirectToIndicatorEdit({{ $indicator->i_id }})">

                                <div class="flex items-start gap-3">
                                    <input type="checkbox" form="delete-indicators-form" name="indicators[]" value="{{ $indicator->i_id }}"
                                           class="indicator-checkbox hidden w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-1">

                                    <div class="flex-1">
                                        <div class="font-bold text-gray-700 text-sm">
                                            Indicador #{{ $indicator->i_num }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{ $indicator->i_text }}
                                        </div>

                                        {{-- Block/Unblock an Indicator --}}
                                        <form method="POST" action="{{ route('indicators.toggleLock', $indicator->i_id) }}" onClick="event.stopPropagation()">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="mt-1 flex items-center gap-2 text-sm font-bold mb-2">
                                                @if($indicator->i_locked)
                                                    {{-- 🔒 Locked --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                                    <span class="text-red-500" title="Desbloquear indicador para los asignados">Cerrado</span>
                                                @else
                                                    {{-- 🔓 Unlocked --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                                                    <span class="text-green-500" title="Bloquear indicador para los asignados">Editable</span>
                                                @endif
                                            </button>

                                        </form>


                                        {{-- (Input forms for updating value — untouched) --}}
                                        <form action="{{ route('indicators.updateValue', $indicator->i_id) }}" method="POST" enctype="multipart/form-data" onClick="event.stopPropagation()" class="mt-3">
                                            @csrf
                                            @method('PUT')

                                            @if($indicator->i_type === 'integer')
                                                <input type="number" name="i_value" value="{{ old('i_value', $indicator->i_value) }}" class="border rounded px-2 py-1 w-full">
                                            @elseif($indicator->i_type === 'string')<div class="relative group">
                                                <textarea
                                                    name="i_value"
                                                    rows="3"
                                                    class="border rounded px-2 py-1 w-full resize-none overflow-hidden auto-grow min-h-[3rem] transition-all duration-200"
                                                    id="textarea-{{ $indicator->i_id }}"
                                                >{{ old('i_value', $indicator->i_value) }}</textarea>
                                                {{-- Expand/Collapse Button --}}
                                                <button
                                                    type="button"
                                                    class="absolute right-2 top-2 text-gray-500 hover:text-gray-800 hidden group-hover:block z-10"
                                                    onclick="toggleExpandTextarea(this, 'textarea-{{ $indicator->i_id }}')"
                                                    title="Expandir texto"
                                                >
                                                    {{-- Down Arrow (default) --}}
                                                    <svg class="w-6 h-6 expand-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>

                                                    {{-- Up Arrow (hidden initially) --}}
                                                    <svg class="w-6 h-6 collapse-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>

                                            </div>
                                            @elseif($indicator->i_type === 'document')
                                                @if(!empty($indicator->i_value))
                                                    @php
                                                        $documents = explode(',', $indicator->i_value);
                                                    @endphp
                                                    <div class="mb-2">
                                                        <p class="font-semibold text-gray-700">Documentos actuales:</p>
                                                        <ul class="list-disc pl-5">
                                                            @foreach($documents as $doc)
                                                                <li class="flex items-center gap-2">

                                                                    <a href="{{ asset('storage/documents/' . trim($doc)) }}" target="_blank" class="text-blue-500 underline">
                                                                        {{ basename(trim($doc)) }}
                                                                    </a>
                                                                    <!-- Delete (X) Button -->
                                                                    <button
                                                                        type="button"
                                                                        onclick="confirmDeleteDocument('{{ $indicator->i_id }}', '{{ $doc }}')"
                                                                        class="text-red-500 hover:text-red-700 text-sm font-bold px-2 py-0 rounded focus:outline-none"
                                                                        title="Eliminar documento">
                                                                        x
                                                                    </button>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <input type="file" name="i_value" class="border rounded px-2 py-1 w-full">
                                            @endif

                                            <button type="submit" class="mt-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                Guardar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No hay indicadores relacionados con este objetivo.</p>
        @endif
    </div>
    <!-- Delete Document Modal (Pop Up)-->
    <div id="deleteDocumentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">¿Estás seguro de que quieres eliminar este documento?</h2>
            <form id="deleteDocumentForm" method="POST" action="{{ route('indicators.removeDocument') }}">
                @csrf
                @method('POST')
                <input type="hidden" name="indicator_id" id="indicatorIdInput">
                <input type="hidden" name="document_name" id="documentNameInput">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Sí, Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{--        Control Delete Document (Pop Up)--}}
    <script>
        function confirmDeleteDocument(indicatorId, documentName) {
            document.getElementById('indicatorIdInput').value = indicatorId;
            document.getElementById('documentNameInput').value = documentName;
            document.getElementById('deleteDocumentModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteDocumentModal').classList.add('hidden');
        }
    </script>
    {{--        Control Delete Document (Pop Up)--}}
    <script>
        function confirmDeleteDocument(indicatorId, documentName) {
            document.getElementById('indicatorIdInput').value = indicatorId;
            document.getElementById('documentNameInput').value = documentName;
            document.getElementById('deleteDocumentModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteDocumentModal').classList.add('hidden');
        }
    </script>

    {{-- Formulario de eliminación separado y al final --}}
    <form id="delete-indicators-form" action="{{ route('indicators.bulkDelete') }}" method="POST" onsubmit="return confirmarBorrado()">
        @csrf
        @method('DELETE')

        <div id="delete-indicators-button-container" class="mt-4 flex justify-end items-center gap-3 hidden">
            <button type="button" onclick="cancelIndicatorDelete()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Cancelar
            </button>
            <button type="button" onclick="showIndicatorConfirmModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Confirmar Borrado
            </button>
        </div>
    </form>

    {{-- Modal de confirmación --}}
    <div id="confirm-indicator-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold mb-4">¿Estás seguro de borrar este(os) indicador(es)?</h2>
            <div class="flex justify-end gap-3">
                <button onclick="closeIndicatorConfirmModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </button>
                <button onclick="submitIndicatorDeleteForm()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    Sí, Borrar
                </button>
            </div>
        </div>
    </div>

        <div id="indicator-warning-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-red-600 mb-4">¡Atención!</h2>
                <p class="text-gray-700 mb-4">Por favor, selecciona al menos un indicador antes de continuar.</p>
                <div class="flex justify-end gap-3">
                    <button onclick="closeIndicatorWarningModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Entendido
                    </button>
                </div>
            </div>
        </div>

        {{-- NEW: Minimal JavaScript --}}
    <script>
        let currentFY = '';

        function showFiscalYear(fy) {
            document.querySelectorAll('.fiscalYearSection').forEach(section => {
                section.style.display = 'none';
            });

            document.querySelectorAll('button[id^="tab-"]').forEach(tab => {
                tab.classList.remove('bg-blue-500', 'text-white');
                tab.classList.add('bg-gray-200');
            });

            const section = document.getElementById('fy-' + fy);
            if (section) {
                section.style.display = 'block';
            }

            const activeTab = document.getElementById('tab-' + fy);
            if (activeTab) {
                activeTab.classList.remove('bg-gray-200');
                activeTab.classList.add('bg-blue-500', 'text-white');
            }

            document.getElementById('currentFiscalYear').value = fy;
            currentFY = fy;
        }

        function confirmCopy() {
            if (!currentFY) {
                alert('Por favor selecciona un año fiscal primero.');
                return false;
            }
            return confirm('¿Estás seguro de copiar los indicadores del año fiscal ' + currentFY + ' al próximo?');
        }

        window.onload = function() {
            let activeFiscalYear = "{{ session('active_fy') }}";
            if (activeFiscalYear && activeFiscalYear !== "") {
                showFiscalYear(activeFiscalYear);
            } else {
                const firstTab = document.querySelector('button[id^="tab-"]');
                if (firstTab) {
                    const firstFY = firstTab.innerText.trim();
                    showFiscalYear(firstFY);
                }
            }
        };
    </script>
        <script>
            let indicatorEditMode = false;

            function enterIndicatorEditMode() {
                indicatorEditMode = !indicatorEditMode;
                let banner = document.getElementById('indicator-edit-mode-banner');

                if (indicatorEditMode) {
                    banner.classList.remove('hidden');
                } else {
                    banner.classList.add('hidden');
                }
            }

            function cancelIndicatorEdit() {
                indicatorEditMode = false;
                document.getElementById('indicator-edit-mode-banner').classList.add('hidden');
            }

            function redirectToIndicatorEdit(id) {
                if (indicatorEditMode) {
                    window.location.href = `/indicators/${id}/edit`;
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 4000);
                }

                let errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 4000);
                }
            });
        </script>

        <script>
            function toggleIndicatorCheckboxes() {
                let checkboxes = document.querySelectorAll('.indicator-checkbox');
                let deleteButtonContainer = document.getElementById('delete-indicators-button-container');

                checkboxes.forEach(checkbox => {
                    checkbox.classList.toggle('hidden');
                });

                if (deleteButtonContainer.style.display === 'none' || deleteButtonContainer.style.display === '') {
                    deleteButtonContainer.style.display = 'block';
                } else {
                    deleteButtonContainer.style.display = 'none';
                }
            }


            function cancelIndicatorDelete() {
                let checkboxes = document.querySelectorAll('.indicator-checkbox');
                let deleteButtonContainer = document.getElementById('delete-indicators-button-container');

                checkboxes.forEach(checkbox => {
                    checkbox.classList.add('hidden');
                    checkbox.checked = false;
                });

                deleteButtonContainer.style.display = 'none';
            }

            function showIndicatorConfirmModal() {
                let selected = document.querySelectorAll('.indicator-checkbox:checked');
                if (selected.length === 0) {
                    document.getElementById('indicator-warning-modal').classList.remove('hidden');
                } else {
                    document.getElementById('confirm-indicator-modal').classList.remove('hidden');
                }
            }

            function closeIndicatorWarningModal() {
                document.getElementById('indicator-warning-modal').classList.add('hidden');
            }

            function closeIndicatorConfirmModal() {
                document.getElementById('confirm-indicator-modal').classList.add('hidden');
            }

            function submitIndicatorDeleteForm() {
                document.getElementById('delete-indicators-form').submit();
            }
        </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textareas = document.querySelectorAll('textarea.auto-grow');

            const autoResize = (el) => {
                el.style.height = 'auto'; // Reset height
                el.style.height = el.scrollHeight + 'px'; // Set to scrollHeight
            };

            // Wait for paint (this is the real fix)
            window.requestAnimationFrame(() => {
                setTimeout(() => {
                    textareas.forEach(autoResize);
                }, 0); // <-- Defer until scrollHeight is accurate
            });

            // Recalculate on input
            textareas.forEach(textarea => {
                textarea.addEventListener('input', () => autoResize(textarea));
            });
        });
    </script>
    <script>
        function toggleExpandTextarea(button, textareaId) {
            const textarea = document.getElementById(textareaId);
            const expandIcon = button.querySelector('.expand-icon');
            const collapseIcon = button.querySelector('.collapse-icon');

            if (!textarea) return;

            // Toggle expand/collapse
            if (textarea.dataset.expanded === 'true') {
                textarea.style.height = 'auto';
                textarea.dataset.expanded = 'false';

                // Show down arrow
                expandIcon.classList.remove('hidden');
                collapseIcon.classList.add('hidden');
            } else {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
                textarea.dataset.expanded = 'true';

                // Show up arrow
                expandIcon.classList.add('hidden');
                collapseIcon.classList.remove('hidden');
            }
        }
    </script>
</x-layout>

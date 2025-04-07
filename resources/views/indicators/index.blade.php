<x-layout>
    <x-slot:heading>
        Plan Estratégico {{$objective->goal->topic->strategicplan->sp_institution}} : Indicadores del Objetivo #{{ $objective->o_num }}

        <a href="{{ route('indicators.create', $objective->o_id) }}"
           class="inline-flex items-center justify-center w-8 h-8 bg-[#1F2937] text-white rounded-full shadow hover:bg-gray-700 transition"
           title="Crear Indicador">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </a>

        <button onclick="enterIndicatorEditMode()" class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow hover:bg-blue-700 transition"
                title="Editar Objetivos">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </button>

        <button onclick="toggleIndicatorCheckboxes()" class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow hover:bg-red-700 transition"
                title="Eliminar Indicadores">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
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

    <div class="px-6 py-4 max-h-auto overflow-y-auto border border-gray-300 rounded-lg shadow-md">
        @if(count($indicators) > 0)

            <div class="space-y-4">
                @foreach($indicators as $indicator)
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 relative group cursor-pointer hover:bg-gray-100 transition"
                         onclick="redirectToIndicatorEdit({{ $indicator->i_id }})">

                        <div class="flex items-start gap-3">
                            {{-- Este checkbox forma parte del form de DELETE --}}
                            <input type="checkbox" form="delete-indicators-form" name="indicators[]" value="{{ $indicator->i_id }}"
                                   class="indicator-checkbox hidden w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-1">

                            <div class="flex-1">
                                <div class="font-bold text-gray-700 text-sm">
                                    Indicador #{{ $indicator->i_num }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $indicator->i_text }}
                                </div>
                                <div class="text-sm text-gray-700 font-semibold mt-1">
                                    Tipo: {{ $indicator->i_type }}
                                </div>

                                {{-- Este form es independiente, para updateValue --}}
                                <form action="{{ route('indicators.updateValue', $indicator->i_id) }}"
                                      method="POST" enctype="multipart/form-data" class="mt-3"
                                      onClick="event.stopPropagation()">
                                    @csrf
                                    @method('PUT')

                                    @if($indicator->i_type === 'integer')
                                        <input type="number" name="i_value" value="{{ $indicator->i_value }}" class="border rounded px-2 py-1 w-full">
                                    @elseif($indicator->i_type === 'string')
                                        <input type="text" name="i_value" value="{{ $indicator->i_value }}" class="border rounded px-2 py-1 w-full">
                                    @elseif($indicator->i_type === 'document')
                                        @if(!empty($indicator->i_value))
                                            <a href="{{ asset('storage/' . $indicator->i_value) }}" target="_blank" class="text-blue-500 underline">Ver documento actual</a><br>
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

            {{-- Formulario de eliminación separado y al final --}}
            <form id="delete-indicators-form" action="{{ route('indicators.bulkDelete') }}" method="POST">
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
                    <h2 class="text-lg font-bold mb-4">¿Estás seguro de borrar estos indicadores?</h2>
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
        @else
            <p class="text-gray-500">No hay indicadores relacionados con este objetivo.</p>
        @endif
    </div>





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
                alert('Por favor, selecciona al menos un indicador para borrar.');
            } else {
                document.getElementById('confirm-indicator-modal').classList.remove('hidden');
            }
        }

        function closeIndicatorConfirmModal() {
            document.getElementById('confirm-indicator-modal').classList.add('hidden');
        }

        function submitIndicatorDeleteForm() {
            document.getElementById('delete-indicators-form').submit();
        }
    </script>


</x-layout>

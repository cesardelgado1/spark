<x-layout>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

        <x-slot:heading>
            <div class="flex justify-between items-center">
                <!-- Título alineado a la izquierda -->
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                    Planes Estratégicos de UPRM - Asuntos del {{ $strategicplan->sp_institution }}
                </h1>
                <div class="flex gap-3 items-center">
                    <a href="{{ route('topics.create', $strategicplan) }}"
                       class="inline-flex items-center justify-center w-8 h-8 bg-[#1F2937] text-white rounded-full shadow hover:bg-gray-700 transition"
                       title="Crear Asunto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </a>

                    <button onclick="toggleCheckboxes()" class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow hover:bg-red-700 transition"
                            title="Eliminar Asuntos">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>

                    <button onclick="enterEditMode()" class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow hover:bg-blue-700 transition"
                            title="Editar Asuntos">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>

                </div>
            </div>
        </x-slot:heading>

        <div id="edit-mode-banner" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Modo Edición Activado!</strong>
            <span class="block sm:inline">Haz clic en un asunto para editarlo.</span>
            <span onclick="cancelEdit()" class="ml-2 cursor-pointer underline hover:text-red-700">Cancelar</span>
        </div>


        <div class="px-6 py-4 max-h-[500px] overflow-y-auto border border-gray-300 rounded-lg shadow-md">

        {{--                    Debug sp_id hasta donde llega (AQUI LLEGA) --}}
{{--        @php--}}
{{--            dd($strategicplan->sp_id);--}}
{{--        @endphp--}}

        @if(count($topics) > 0)
            <form id="delete-form" action="{{ route('topics.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="space-y-4">
                    @foreach($topics as $topic)
                        <div onclick="redirectToEdit({{ $topic->t_id }})"
                             class="flex items-center justify-between px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="topics[]" value="{{ $topic->t_id }}" class="topic-checkbox hidden w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded">

                                <div>
                                    <div class="font-bold text-gray-700 text-sm">
                                        Asunto #{{ $topic->t_num }}
                                    </div>
                                    <div class="text-gray-500">
                                        {{ $topic->t_text }}
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('topics.goals', ['topic' => $topic->t_id]) }}" class="text-blue-500 hover:text-blue-700 transition">
                                Ver Metas
                            </a>
                        </div>
                    @endforeach

                </div>

                <div id="delete-button-container" class="mt-4 flex justify-end items-center gap-3" style="display: none;">
                    <button type="button" onclick="cancelDelete()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cancelar
                    </button>

                    <button type="button" onclick="showConfirmModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Confirmar Borrado
                    </button>
                </div>

            </form>
        @else
            <p class="text-gray-500">No hay asuntos relacionados con este plan estratégico.</p>
        @endif

    </div>

        <div id="topic-warning-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-red-600 mb-4">¡Atención!</h2>
                <p class="text-gray-700 mb-4">Por favor, selecciona al menos un asunto antes de continuar.</p>
                <div class="flex justify-end gap-3">
                    <button onclick="closeTopicWarningModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Entendido
                    </button>
                </div>
            </div>
        </div>


        <script>
            function toggleCheckboxes() {
                let checkboxes = document.querySelectorAll('.topic-checkbox');
                let deleteButtonContainer = document.getElementById('delete-button-container');

                checkboxes.forEach(checkbox => {
                    checkbox.classList.toggle('hidden');
                });

                if (deleteButtonContainer.style.display === 'none' || deleteButtonContainer.style.display === '') {
                    deleteButtonContainer.style.display = 'block';
                } else {
                    deleteButtonContainer.style.display = 'none';
                }
            }

            function cancelDelete() {
                let checkboxes = document.querySelectorAll('.topic-checkbox');
                let deleteButtonContainer = document.getElementById('delete-button-container');

                checkboxes.forEach(checkbox => {
                    checkbox.classList.add('hidden');
                    checkbox.checked = false;
                });

                deleteButtonContainer.style.display = 'none';
            }

            function showConfirmModal() {
                let selectedCheckboxes = document.querySelectorAll('.topic-checkbox:checked');

                if (selectedCheckboxes.length === 0) {
                    document.getElementById('topic-warning-modal').classList.remove('hidden');
                } else {
                    document.getElementById('confirm-modal').classList.remove('hidden');
                }
            }

            function closeTopicWarningModal() {
                document.getElementById('topic-warning-modal').classList.add('hidden');
            }

            function closeConfirmModal() {
                document.getElementById('confirm-modal').classList.add('hidden');
            }

            function submitDeleteForm() {
                document.getElementById('delete-form').submit();
            }


        </script>

        <div id="confirm-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold mb-4">¿Estás seguro de borrar estos datos?</h2>
                <div class="flex justify-end gap-3">
                    <!-- Botón para cancelar -->
                    <button onclick="closeConfirmModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <!-- Botón para confirmar eliminación -->
                    <button onclick="submitDeleteForm()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Sí, Borrar
                    </button>
                </div>
            </div>
        </div>

        <script>
            let editMode = false;

            function enterEditMode() {
                editMode = !editMode;
                let banner = document.getElementById('edit-mode-banner');

                if (editMode) {
                    banner.classList.remove('hidden');
                } else {
                    banner.classList.add('hidden');
                }
            }

            function redirectToEdit(id) {
                if (editMode) {
                    window.location.href = `/topics/${id}/edit`;
                }
            }

            function cancelEdit() {
                editMode = false;
                let banner = document.getElementById('edit-mode-banner');
                banner.classList.add('hidden');
            }

        </script>


</x-layout>

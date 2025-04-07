<x-layout>

    <x-slot:heading>
        Plan Estratégico {{$topic->strategicplan->sp_institution}} : Metas del Asunto #{{ $topic->t_num }}

        <a href="{{ route('goals.create', ['topic' => $topic->t_id]) }}"
           class="inline-flex items-center justify-center w-8 h-8 bg-[#1F2937] text-white rounded-full shadow hover:bg-gray-700 transition"
           title="Crear Meta">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>

        <button onclick="toggleGoalCheckboxes()" class="inline-flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow hover:bg-red-700 transition"
                title="Eliminar Metas">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>

        <button onclick="enterGoalEditMode()" class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow hover:bg-blue-700 transition"
                title="Editar Metas">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
        </button>

    </x-slot:heading>

    {{-- Breadcrumb --}}
    <x-breadcrumb :strategicplan="$topic->strategicplan" :topic="$topic" />

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


    <div id="goal-edit-mode-banner" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-2" role="alert">
        <strong class="font-bold">¡Modo Edición Activado!</strong>
        <span class="inline-block sm:inline">Haz clic en una meta para editarla.</span>

        <span onclick="cancelGoalEdit()" class="ml-2 cursor-pointer underline hover:text-red-700">
        Cancelar
    </span>
    </div>

    <div class="px-6 py-4 max-h-auto overflow-y-auto border border-gray-300 rounded-lg shadow-md">
        @if(count($goals) > 0)
            <form id="delete-goals-form" action="{{ route('goals.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="space-y-4">
                    @foreach($goals as $goal)
                        <div onclick="redirectToGoalEdit({{ $goal->g_id }})"
                             class="flex items-center justify-between px-4 py-4 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition cursor-pointer">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="goals[]" value="{{ $goal->g_id }}" class="goal-checkbox hidden w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded">

                                <div>
                                    <div class="font-bold text-gray-700 text-sm">
                                        Meta #{{ $goal->g_num }}
                                    </div>
                                    <div class="text-gray-500">
                                        {{ $goal->g_text }}
                                        <a href="{{ route('goals.objectives', ['goal' => $goal->g_id]) }}" class="text-blue-500 hover:text-blue-700 transition">
                                            Ver Objetivos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div id="delete-goal-button-container" class="mt-4 flex justify-end items-center gap-3 hidden">
                    <button type="button" onclick="cancelGoalDelete()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <button type="button" onclick="showGoalConfirmModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Confirmar Borrado
                    </button>
                </div>

{{--                <div id="goal-error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">--}}
{{--                    <strong class="font-bold">¡Atención!</strong>--}}
{{--                    <span class="block sm:inline">Por favor, selecciona al menos una meta antes de continuar.</span>--}}
{{--                </div>--}}

            </form>


        @else
            <p class="text-gray-500">No hay metas relacionadas con este asunto.</p>
        @endif

            <div id="confirm-goal-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold mb-4">¿Estás seguro de borrar estas metas?</h2>
                    <div class="flex justify-end gap-3">
                        <button onclick="closeGoalConfirmModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            Cancelar
                        </button>
                        <button onclick="submitGoalDeleteForm()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Sí, Borrar
                        </button>
                    </div>
                </div>
            </div>


    </div>

    <div id="goal-warning-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-red-600 mb-4">¡Atención!</h2>
            <p class="text-gray-700 mb-4">Por favor, selecciona al menos una meta antes de continuar.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeGoalWarningModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Entendido
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleGoalCheckboxes() {
            let checkboxes = document.querySelectorAll('.goal-checkbox');
            let deleteButtonContainer = document.getElementById('delete-goal-button-container');

            checkboxes.forEach(checkbox => {
                checkbox.classList.toggle('hidden');
            });

            if (deleteButtonContainer.style.display === 'none' || deleteButtonContainer.style.display === '') {
                deleteButtonContainer.style.display = 'block';
            } else {
                deleteButtonContainer.style.display = 'none';
            }
        }

        function cancelGoalDelete() {
            let checkboxes = document.querySelectorAll('.goal-checkbox');
            let deleteButtonContainer = document.getElementById('delete-goal-button-container');

            checkboxes.forEach(checkbox => {
                checkbox.classList.add('hidden');
                checkbox.checked = false;
            });

            deleteButtonContainer.style.display = 'none';
        }

        function showGoalConfirmModal() {
            let selectedCheckboxes = document.querySelectorAll('.goal-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                document.getElementById('goal-warning-modal').classList.remove('hidden');
            } else {
                document.getElementById('confirm-goal-modal').classList.remove('hidden');
            }
        }


        function closeGoalWarningModal() {
            document.getElementById('goal-warning-modal').classList.add('hidden');
        }

        function submitGoalDeleteForm() {
            document.getElementById('delete-goals-form').submit();
        }
    </script>

    <script>
        let goalEditMode = false;

        function enterGoalEditMode() {
            goalEditMode = !goalEditMode;
            let banner = document.getElementById('goal-edit-mode-banner');

            if (goalEditMode) {
                banner.classList.remove('hidden');
            } else {
                banner.classList.add('hidden');
            }
        }

        function cancelGoalEdit() {
            goalEditMode = false;
            document.getElementById('goal-edit-mode-banner').classList.add('hidden');
        }

        function redirectToGoalEdit(id) {
            if (goalEditMode) {
                window.location.href = `/goals/${id}/edit`;
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





</x-layout>

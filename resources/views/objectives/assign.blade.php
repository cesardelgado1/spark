<x-layout>
    {{-- Page heading with goal number --}}
    <x-slot:heading>
        Asignar Objetivos a Contribuidores - Meta #{{ $goal->g_num }}
    </x-slot:heading>

    {{-- Flash message on successful assignment --}}
    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Assignment Form --}}
    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form id="assign-form" action="{{ route('assignobjectives.store') }}" method="POST">
            @csrf

            {{-- Dropdown to select an objective --}}
            <div class="mb-6">
                <label for="objective_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Objetivo</label>
                <select name="objective_id" id="objective_id" class="w-full border border-gray-300 rounded px-4 py-2">
                    @foreach ($objectives as $objective)
                        <option value="{{ $objective->o_id }}"
                            {{ (old('objective_id', session('selected_objective', $objectives->first()->o_id)) == $objective->o_id) ? 'selected' : '' }}>
                            #{{ $objective->o_num }} - {{ Str::limit($objective->o_text, 60) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Display currently assigned contributors --}}
            <div id="assigned-contributors" class="hidden mb-6">
                <h3 class="text-md font-semibold text-gray-800 mb-3">Contribuidores Asignados:</h3>
                <div id="assigned-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
            </div>

            {{-- Checkbox list of contributors to assign --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Contribuidores Nuevos</label>
                <div id="contributors-checkboxes" class="space-y-2 max-h-64 overflow-y-auto border p-3 rounded">
                    @foreach ($contributors as $contributor)
                        <label class="flex items-center space-x-2 contributor-checkbox" data-user-id="{{ $contributor->id }}">
                            <input type="checkbox" name="user_ids[]" value="{{ $contributor->id }}"
                                   class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span>{{ $contributor->u_fname }} {{ $contributor->u_lname }} ({{ $contributor->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('goals.objectives', ['goal' => $goal->g_id]) }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Asignar Objetivo
                </button>
            </div>
        </form>
    </div>

    {{-- Modal: Confirm Unassign --}}
    <div id="unassign-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold mb-4 text-red-600">¿Estás seguro de desasignar este usuario?</h2>
            <div class="flex justify-end gap-3">
                <button onclick="closeUnassignModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </button>
                <button onclick="confirmUnassign()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    Sí, Desasignar
                </button>
            </div>
        </div>
    </div>

    {{-- Modal: No contributors selected warning --}}
    <div id="assign-warning-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-red-600 mb-4">¡Atención!</h2>
            <p class="text-gray-700 mb-4">Por favor, selecciona al menos un contribuidor antes de asignar.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeAssignWarningModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Entendido
                </button>
            </div>
        </div>
    </div>
</x-layout>

{{-- JavaScript Section --}}
<script>
    // Data from controller
    const assignedMap = @json($assignedMap);
    const contributors = @json($contributors->keyBy('id'));

    const objectiveSelect = document.getElementById('objective_id');
    const assignedContributorsDiv = document.getElementById('assigned-contributors');
    const assignedList = document.getElementById('assigned-list');
    const contributorCheckboxes = document.querySelectorAll('.contributor-checkbox');

    let pendingUnassignId = null;
    let pendingUserId = null;

    // Populate list of assigned users
    function updateAssignedContributors(objectiveId) {
        assignedList.innerHTML = '';

        if (assignedMap[objectiveId] && assignedMap[objectiveId].length > 0) {
            assignedContributorsDiv.classList.remove('hidden');

            assignedMap[objectiveId].forEach(entry => {
                const user = contributors[entry.user_id];
                const aoId = entry.ao_id;

                if (user) {
                    const card = document.createElement('div');
                    card.className = "p-4 bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition relative";
                    card.id = `assignment-card-${aoId}`;

                    card.innerHTML = `
                        <div class="font-bold text-gray-800">${user.u_fname} ${user.u_lname}</div>
                        <div class="text-sm text-gray-500">${user.email}</div>
                        <button
                            type="button"
                            onclick="unassignUser(${aoId}, ${entry.user_id})"
                            class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm"
                            title="Desasignar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" ...>
                                <path ... />
                            </svg>
                        </button>
                    `;
                    assignedList.appendChild(card);
                }
            });
        } else {
            assignedContributorsDiv.classList.add('hidden');
        }
    }

    // Hide checkboxes for already assigned contributors
    function updateContributorCheckboxes(objectiveId) {
        const assignedEntries = assignedMap[objectiveId] || [];
        const assignedUserIds = assignedEntries.map(entry => entry.user_id);

        contributorCheckboxes.forEach(label => {
            const userId = parseInt(label.dataset.userId);
            const input = label.querySelector('input[type="checkbox"]');

            if (assignedUserIds.includes(userId)) {
                label.classList.add('hidden');
                input.checked = false;
            } else {
                label.classList.remove('hidden');
            }
        });
    }

    // When a different objective is selected
    objectiveSelect.addEventListener('change', function () {
        updateAssignedContributors(this.value);
        updateContributorCheckboxes(this.value);
    });

    // On load: initialize contributor and assignment lists
    document.addEventListener('DOMContentLoaded', function () {
        updateAssignedContributors({{ $objectives->first()->o_id }});
        updateContributorCheckboxes({{ $objectives->first()->o_id }});

        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }
    });

    // Trigger unassign confirmation modal
    function unassignUser(aoId, userId) {
        pendingUnassignId = aoId;
        pendingUserId = userId;
        document.getElementById('unassign-modal').classList.remove('hidden');
    }

    // Close unassign modal
    function closeUnassignModal() {
        pendingUnassignId = null;
        pendingUserId = null;
        document.getElementById('unassign-modal').classList.add('hidden');
    }

    // Confirm and process unassignment via AJAX
    function confirmUnassign() {
        if (!pendingUnassignId) return;

        fetch(`/assignments/${pendingUnassignId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove card from DOM
                    const card = document.getElementById(`assignment-card-${pendingUnassignId}`);
                    if (card) card.remove();

                    // Update map and checkboxes
                    assignedMap[objectiveSelect.value] = assignedMap[objectiveSelect.value].filter(e => e.user_id !== pendingUserId);
                    updateContributorCheckboxes(objectiveSelect.value);

                    // Hide container if empty
                    if (assignedList.children.length === 0) {
                        assignedContributorsDiv.classList.add('hidden');
                    }
                } else {
                    alert('Error al desasignar. Inténtalo de nuevo.');
                }
                closeUnassignModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al desasignar. Inténtalo de nuevo.');
                closeUnassignModal();
            });
    }

    // Warn if no contributor is selected when submitting the form
    document.getElementById('assign-form').addEventListener('submit', function (event) {
        const selectedCheckboxes = document.querySelectorAll('input[name="user_ids[]"]:checked');
        if (selectedCheckboxes.length === 0) {
            event.preventDefault();
            document.getElementById('assign-warning-modal').classList.remove('hidden');
        }
    });

    // Close warning modal
    function closeAssignWarningModal() {
        document.getElementById('assign-warning-modal').classList.add('hidden');
    }
</script>

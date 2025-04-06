<x-layout>
    <x-slot:heading>
        Asignar Objetivos a Asignados - Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    {{-- Success message --}}
    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form action="{{ route('assignments.assign', $objective->o_id) }}" method="POST">
            @csrf

            {{-- Select Objective (readonly) --}}
            <div class="mb-6">
                <label for="objective_id" class="block text-sm font-medium text-gray-700 mb-2">Objetivo</label>
                <input type="text" readonly value="#{{ $objective->o_num }} - {{ Str::limit($objective->o_text, 80) }}"
                       class="w-full bg-gray-100 border border-gray-300 rounded px-4 py-2">
            </div>

            {{-- Assigned Assignees --}}
            <div id="assigned-assignees" class="hidden mb-6">
                <h3 class="text-md font-semibold text-gray-800 mb-3">Asignados Existentes:</h3>
                <div id="assigned-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Existing Assignees will be inserted dynamically -->
                </div>
            </div>

            {{-- Select Assignees --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Asignados Nuevos</label>
                <div id="assignees-checkboxes" class="space-y-2 max-h-64 overflow-y-auto border p-3 rounded">
                    @foreach ($assignees as $assignee)
                        <label class="flex items-center space-x-2 assignee-checkbox" data-user-id="{{ $assignee->id }}">
                            <input type="checkbox" name="user_ids[]" value="{{ $assignee->id }}"
                                   class="text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span>{{ $assignee->u_fname }} {{ $assignee->u_lname }} ({{ $assignee->email }})</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Asignar Objetivo
                </button>
            </div>
        </form>
    </div>

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
</x-layout>

{{-- Scripts --}}
<script>
    const assignedMap = @json($assignedMap);
    const assignees = @json($assignees->keyBy('id'));

    const assignedAssigneesDiv = document.getElementById('assigned-assignees');
    const assignedList = document.getElementById('assigned-list');
    const assigneeCheckboxes = document.querySelectorAll('.assignee-checkbox');

    function updateAssignedAssignees(objectiveId) {
        assignedList.innerHTML = '';

        if (assignedMap[objectiveId] && assignedMap[objectiveId].length > 0) {
            assignedAssigneesDiv.classList.remove('hidden');

            assignedMap[objectiveId].forEach(entry => {
                const user = assignees[entry.user_id];
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    `;
                    assignedList.appendChild(card);
                }
            });
        } else {
            assignedAssigneesDiv.classList.add('hidden');
        }
    }

    function updateAssigneeCheckboxes(objectiveId) {
        const assignedEntries = assignedMap[objectiveId] || [];
        const assignedUserIds = assignedEntries.map(entry => entry.user_id);

        assigneeCheckboxes.forEach(checkboxLabel => {
            const userId = parseInt(checkboxLabel.dataset.userId);
            const input = checkboxLabel.querySelector('input[type="checkbox"]');

            if (assignedUserIds.includes(userId)) {
                checkboxLabel.classList.add('hidden');
                input.checked = false;
            } else {
                checkboxLabel.classList.remove('hidden');
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateAssignedAssignees({{ $objective->o_id }});
        updateAssigneeCheckboxes({{ $objective->o_id }});
    });

    let pendingUnassignId = null;
    let pendingUserId = null;

    function unassignUser(aoId, userId) {
        pendingUnassignId = aoId;
        pendingUserId = userId;
        document.getElementById('unassign-modal').classList.remove('hidden');
    }

    function closeUnassignModal() {
        pendingUnassignId = null;
        pendingUserId = null;
        document.getElementById('unassign-modal').classList.add('hidden');
    }

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
                    const card = document.getElementById(`assignment-card-${pendingUnassignId}`);
                    if (card) {
                        card.remove();
                    }

                    // Remove from assignedMap
                    assignedMap[{{ $objective->o_id }}] = assignedMap[{{ $objective->o_id }}].filter(entry => entry.user_id !== pendingUserId);

                    // Refresh available assignees list
                    updateAssigneeCheckboxes({{ $objective->o_id }});

                    if (assignedList.children.length === 0) {
                        assignedAssigneesDiv.classList.add('hidden');
                    }

                    console.log('Usuario desasignado exitosamente.');
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 4 seconds (adjust as you wish)
        }
    });
</script>


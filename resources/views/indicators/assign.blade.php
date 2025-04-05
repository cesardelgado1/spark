<x-layout>
    <x-slot:heading>
        Asignar Objetivos a Asignados - Objetivo #{{ $objective->o_num }}
    </x-slot:heading>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
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

            assignedMap[objectiveId].forEach(userId => {
                const user = assignees[userId];
                if (user) {
                    const card = document.createElement('div');
                    card.className = "p-4 bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg transition";

                    card.innerHTML = `
                        <div class="font-bold text-gray-800">${user.u_fname} ${user.u_lname}</div>
                        <div class="text-sm text-gray-500">${user.email}</div>
                    `;

                    assignedList.appendChild(card);
                }
            });
        } else {
            assignedAssigneesDiv.classList.add('hidden');
        }
    }

    function updateAssigneeCheckboxes(objectiveId) {
        const assignedUsers = assignedMap[objectiveId] || [];

        assigneeCheckboxes.forEach(checkboxLabel => {
            const userId = checkboxLabel.dataset.userId;
            const input = checkboxLabel.querySelector('input[type="checkbox"]');

            if (assignedUsers.includes(parseInt(userId))) {
                checkboxLabel.classList.add('hidden');
                input.checked = false;
            } else {
                checkboxLabel.classList.remove('hidden');
            }
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        updateAssignedAssignees({{ $objective->o_id }});
        updateAssigneeCheckboxes({{ $objective->o_id }});
    });
</script>

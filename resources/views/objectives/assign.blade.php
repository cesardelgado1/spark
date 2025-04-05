<x-layout>
    <x-slot:heading>
        Asignar Objetivos a Contribuidores - Meta #{{ $goal->g_num }}
    </x-slot:heading>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form action="{{ route('assignobjectives.store') }}" method="POST">
            @csrf

            {{-- Select Objective --}}
            <div class="mb-6">
                <label for="objective_id" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Objetivo</label>
                <select name="objective_id" id="objective_id" class="w-full border border-gray-300 rounded px-4 py-2">
                    @foreach ($objectives as $objective)
                        <option value="{{ $objective->o_id }}"
                            {{ (old('objective_id', session('selected_objective')) == $objective->o_id) ? 'selected' : '' }}>
                            #{{ $objective->o_num }} - {{ Str::limit($objective->o_text, 60) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Assigned Contributors --}}
            <div id="assigned-contributors" class="hidden mb-6">
                <h3 class="text-md font-semibold text-gray-800 mb-3">Contribuidores Asignados:</h3>
                <div id="assigned-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contributors will be inserted dynamically here -->
                </div>
            </div>

            {{-- Select Contributors --}}
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

            {{-- Submit --}}
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
</x-layout>

{{-- Scripts --}}
<script>
    const assignedMap = @json($assignedMap);
    const contributors = @json($contributors->keyBy('id')); // Easy lookup by user ID

    const objectiveSelect = document.getElementById('objective_id');
    const assignedContributorsDiv = document.getElementById('assigned-contributors');
    const assignedList = document.getElementById('assigned-list');
    const contributorCheckboxes = document.querySelectorAll('.contributor-checkbox');

    function updateAssignedContributors(objectiveId) {
        assignedList.innerHTML = '';

        if (assignedMap[objectiveId] && assignedMap[objectiveId].length > 0) {
            assignedContributorsDiv.classList.remove('hidden');

            assignedMap[objectiveId].forEach(userId => {
                const user = contributors[userId];
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
            assignedContributorsDiv.classList.add('hidden');
        }
    }

    function updateContributorCheckboxes(objectiveId) {
        const assignedUsers = assignedMap[objectiveId] || [];

        contributorCheckboxes.forEach(checkboxLabel => {
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

    objectiveSelect.addEventListener('change', function () {
        const selectedObjectiveId = this.value;

        updateAssignedContributors(selectedObjectiveId);
        updateContributorCheckboxes(selectedObjectiveId);
    });

    // Trigger initial load
    objectiveSelect.dispatchEvent(new Event('change'));
</script>

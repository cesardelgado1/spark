<x-layout>
    <x-slot:heading>
        Reportes
    </x-slot:heading>

    <!-- Dropdowns Section -->
    <div class="p-4">
        <div class="mb-4">
            <label for="strategic-plan" class="block text-sm font-medium text-gray-700">Select Strategic Plan to Export</label>
            <select id="strategic-plan" name="strategic_plan" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Select Strategic Plan --</option>
                @foreach($strategicPlans as $plan)
                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <form id="export-form" action="{{ url('/export') }}" method="POST" class="p-4">
        @csrf
        <input type="hidden" name="sp_id" id="form-sp-id">

        <div class="flex space-x-4">
            <!-- Asuntos Section -->
            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-asuntos" name="include_asuntos">
                    <h3 class="text-lg font-bold">Asuntos</h3>
                </label>
                <div id="topics-list" class="space-y-4 ml-7"></div>
            </div>

            <!-- Metas Section -->
            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-metas" name="include_metas">
                    <h3 class="text-lg font-bold">Metas</h3>
                </label>
                <div id="goals-list" class="space-y-4 ml-7"></div>
            </div>

            <!-- Objetivos Section -->
            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">
                <label class="flex items-center space-x-2 mb-2">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-objetivos" name="include_objetivos">
                    <h3 class="text-lg font-bold">Objetivos</h3>
                </label>
                <div id="objectives-list" class="space-y-4 ml-7"></div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Generate Excel
            </button>
        </div>
    </form>

    {{--WORKS POR FIN!!!!!!!!!!!!! YAY WOHOOOOOO--}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdown = document.getElementById('strategic-plan');
            const topicsList = document.getElementById('topics-list');
            const goalsList = document.getElementById('goals-list');
            const objectivesList = document.getElementById('objectives-list');
            const formSpId = document.getElementById('form-sp-id');

            const toggleAsuntos = document.getElementById('toggle-asuntos');
            const toggleMetas = document.getElementById('toggle-metas');
            const toggleObjetivos = document.getElementById('toggle-objetivos');

            // Recalculate sets directly from checkboxes
            function getSelected(container) {
                return new Set(
                    [...container.querySelectorAll('input[type="checkbox"]:checked')].map(cb => cb.value)
                );
            }

            function syncParentCheckbox(parentCheckbox, container) {
                const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                const checked = container.querySelectorAll('input[type="checkbox"]:checked').length;
                const total = checkboxes.length;

                parentCheckbox.checked = checked === total && total > 0;
                parentCheckbox.indeterminate = checked > 0 && checked < total;
            }

            function bindCheckboxes(container, onChangeCallback, parentToggle) {
                container.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    cb.addEventListener('change', () => {
                        onChangeCallback();
                        syncParentCheckbox(parentToggle, container);
                    });
                });
            }

            toggleAsuntos.addEventListener('change', () => {
                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleAsuntos.checked);
                syncParentCheckbox(toggleAsuntos, topicsList);
                loadGoalsFromSelectedTopics();
            });

            toggleMetas.addEventListener('change', () => {
                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleMetas.checked);
                syncParentCheckbox(toggleMetas, goalsList);
                loadObjectivesFromSelectedGoals();
            });

            toggleObjetivos.addEventListener('change', () => {
                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);
                syncParentCheckbox(toggleObjetivos, objectivesList);
            });

            dropdown.addEventListener('change', function () {
                const planId = this.value;
                formSpId.value = planId;

                topicsList.innerHTML = '';
                goalsList.innerHTML = '';
                objectivesList.innerHTML = '';

                if (planId) {
                    fetch(`/reportes/${planId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(topic => {
                                const wrapper = document.createElement('div');
                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';

                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.name = 'topics[]';
                                checkbox.value = topic.t_id;
                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';
                                checkbox.checked = true;

                                const label = document.createElement('label');
                                label.textContent = `Asunto ${topic.t_num}`;
                                label.className = 'font-medium';

                                wrapper.appendChild(checkbox);
                                wrapper.appendChild(label);
                                topicsList.appendChild(wrapper);
                            });

                            syncParentCheckbox(toggleAsuntos, topicsList);
                            bindCheckboxes(topicsList, loadGoalsFromSelectedTopics, toggleAsuntos);
                            loadGoalsFromSelectedTopics();
                        });
                }
            });

            function loadGoalsFromSelectedTopics() {
                const selectedTopics = getSelected(topicsList);
                goalsList.innerHTML = '';
                objectivesList.innerHTML = '';

                if (selectedTopics.size === 0) {
                    syncParentCheckbox(toggleMetas, goalsList);
                    syncParentCheckbox(toggleObjetivos, objectivesList);
                    return;
                }

                const seen = new Set();

                Promise.all(
                    [...selectedTopics].map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json()))
                ).then(results => {
                    results.flat().forEach(goal => {
                        if (seen.has(goal.g_id)) return;
                        seen.add(goal.g_id);

                        const wrapper = document.createElement('div');
                        wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'goals[]';
                        checkbox.value = goal.g_id;
                        checkbox.className = 'form-checkbox h-4 w-4 text-green-600';
                        checkbox.checked = true;

                        const label = document.createElement('label');
                        label.textContent = `Meta ${goal.g_num}`;
                        label.className = 'font-medium';

                        wrapper.appendChild(checkbox);
                        wrapper.appendChild(label);
                        goalsList.appendChild(wrapper);
                    });

                    syncParentCheckbox(toggleMetas, goalsList);
                    bindCheckboxes(goalsList, loadObjectivesFromSelectedGoals, toggleMetas);
                    loadObjectivesFromSelectedGoals();
                });
            }

            function loadObjectivesFromSelectedGoals() {
                const selectedGoals = getSelected(goalsList);
                objectivesList.innerHTML = '';

                if (selectedGoals.size === 0) {
                    syncParentCheckbox(toggleObjetivos, objectivesList);
                    return;
                }

                const seen = new Set();

                Promise.all(
                    [...selectedGoals].map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json()))
                ).then(results => {
                    results.flat().forEach(obj => {
                        if (seen.has(obj.o_id)) return;
                        seen.add(obj.o_id);

                        const wrapper = document.createElement('div');
                        wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'objectives[]';
                        checkbox.value = obj.o_id;
                        checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';
                        checkbox.checked = true;

                        const label = document.createElement('label');
                        // label.textContent = `Objetivo #${obj.o_num}`;
                        label.textContent = `Objetivo ${obj.t_num}.${obj.g_num}.${obj.o_num}`;

                        label.className = 'font-medium';

                        wrapper.appendChild(checkbox);
                        wrapper.appendChild(label);
                        objectivesList.appendChild(wrapper);
                    });

                    syncParentCheckbox(toggleObjetivos, objectivesList);
                    bindCheckboxes(objectivesList, () => {}, toggleObjetivos);

                });
            }
        });
    </script>

</x-layout>


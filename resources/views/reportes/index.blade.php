{{--<x-layout>--}}
{{--    <x-slot:heading>--}}
{{--        Reportes--}}
{{--    </x-slot:heading>--}}

{{--    <!-- Dropdowns Section -->--}}
{{--    <div class="p-4">--}}
{{--        <div class="mb-4">--}}
{{--            <label for="strategic-plan" class="block text-sm font-medium text-gray-700">Select Strategic Plan to Export</label>--}}
{{--            <select id="strategic-plan" name="strategic_plan" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Select Strategic Plan --</option>--}}
{{--                @foreach($strategicPlans as $plan)--}}
{{--                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}

{{--        </div>--}}

{{--  TO-DO  (Missing FY in database) --}}
{{--        <div class="mb-4">--}}
{{--            <label for="fiscal-year" class="block text-sm font-medium text-gray-700">Select Fiscal Year</label>--}}
{{--            <select id="fiscal-year" name="fiscal_year" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Select Fiscal Year --</option>--}}
{{--                @foreach($strategicPlans as $plan)--}}
{{--                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="flex space-x-4 p-4">--}}
{{--        <!-- Asuntos Section -->--}}
{{--        <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--            <label class="flex items-center space-x-2 mb-2">--}}
{{--                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">--}}
{{--                <h3 class="text-lg font-bold">Asuntos</h3>--}}
{{--            </label>--}}
{{--            <div id="topics-list" class="space-y-4 ml-7">--}}
{{--                <!-- Topics will be dynamically shown here -->--}}
{{--            </div>--}}

{{--        </div>--}}

{{--        <!-- Metas Section -->--}}
{{--        <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--            <label class="flex items-center space-x-2 mb-2">--}}
{{--                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">--}}
{{--                <h3 class="text-lg font-bold">Metas</h3>--}}
{{--            </label>--}}
{{--            <div id="goals-list" class="space-y-4 ml-7">--}}
{{--                <!-- Goals will be dynamically shown here -->--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Objetivos Section -->--}}
{{--        <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--            <label class="flex items-center space-x-2 mb-2">--}}
{{--                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">--}}
{{--                <h3 class="text-lg font-bold">Objetivos</h3>--}}
{{--            </label>--}}
{{--            <div id="objectives-list" class="space-y-4 ml-7">--}}
{{--                <!-- Objectives will be dynamically shown here -->--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            if (data.length === 0) {--}}
{{--                                topicsList.innerHTML = '<div class="text-sm text-gray-500">No topics found.</div>';--}}
{{--                            } else {--}}
{{--                                data.forEach(topic => {--}}
{{--                                    const wrapper = document.createElement('div');--}}
{{--                                    wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                    const checkbox = document.createElement('input');--}}
{{--                                    checkbox.type = 'checkbox';--}}
{{--                                    checkbox.name = 'topics[]';--}}
{{--                                    checkbox.value = topic.t_id;--}}
{{--                                    checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}

{{--                                    checkbox.addEventListener('change', function () {--}}
{{--                                        if (this.checked) {--}}
{{--                                            selectedTopics.add(topic.t_id);--}}
{{--                                        } else {--}}
{{--                                            selectedTopics.delete(topic.t_id);--}}
{{--                                        }--}}
{{--                                        loadGoalsFromSelectedTopics();--}}
{{--                                    });--}}

{{--                                    const label = document.createElement('label');--}}
{{--                                    label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                    label.className = 'font-medium';--}}

{{--                                    wrapper.appendChild(checkbox);--}}
{{--                                    wrapper.appendChild(label);--}}

{{--                                    topicsList.appendChild(wrapper);--}}
{{--                                });--}}
{{--                            }--}}
{{--                        })--}}
{{--                        .catch(error => {--}}
{{--                            console.error('Error fetching topics:', error);--}}
{{--                            topicsList.innerHTML = '<div class="text-sm text-red-500">Error loading topics.</div>';--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(--}}
{{--                    topicIdsArray.map(id =>--}}
{{--                        fetch(`/reportes/topics/${id}/goals`).then(res => res.json())--}}
{{--                    )--}}
{{--                ).then(results => {--}}
{{--                    const allGoals = results.flat();--}}
{{--                    const renderedGoalIds = new Set();--}}

{{--                    allGoals.forEach(goal => {--}}
{{--                        if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                            renderedGoalIds.add(goal.g_id);--}}

{{--                            const wrapper = document.createElement('div');--}}
{{--                            wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                            const checkbox = document.createElement('input');--}}
{{--                            checkbox.type = 'checkbox';--}}
{{--                            checkbox.name = 'goals[]';--}}
{{--                            checkbox.value = goal.g_id;--}}
{{--                            checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}

{{--                            checkbox.addEventListener('change', function () {--}}
{{--                                if (this.checked) {--}}
{{--                                    selectedGoals.add(goal.g_id);--}}
{{--                                } else {--}}
{{--                                    selectedGoals.delete(goal.g_id);--}}
{{--                                }--}}
{{--                                loadObjectivesFromSelectedGoals();--}}
{{--                            });--}}

{{--                            const label = document.createElement('label');--}}
{{--                            label.textContent = `Meta #${goal.g_num}`;--}}
{{--                            label.className = 'font-medium';--}}

{{--                            wrapper.appendChild(checkbox);--}}
{{--                            wrapper.appendChild(label);--}}

{{--                            goalsList.appendChild(wrapper);--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(--}}
{{--                    goalIdsArray.map(id =>--}}
{{--                        fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())--}}
{{--                    )--}}
{{--                ).then(results => {--}}
{{--                    const allObjectives = results.flat();--}}
{{--                    const renderedObjectiveIds = new Set();--}}

{{--                    allObjectives.forEach(obj => {--}}
{{--                        if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                            renderedObjectiveIds.add(obj.o_id);--}}

{{--                            const wrapper = document.createElement('div');--}}
{{--                            wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                            const checkbox = document.createElement('input');--}}
{{--                            checkbox.type = 'checkbox';--}}
{{--                            checkbox.name = 'objectives[]';--}}
{{--                            checkbox.value = obj.o_id;--}}
{{--                            checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}

{{--                            const label = document.createElement('label');--}}
{{--                            label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                            label.className = 'font-medium';--}}

{{--                            wrapper.appendChild(checkbox);--}}
{{--                            wrapper.appendChild(label);--}}

{{--                            objectivesList.appendChild(wrapper);--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


{{--</x-layout>--}}

{{--<x-layout>--}}
{{--    <x-slot:heading>--}}
{{--        Reportes--}}
{{--    </x-slot:heading>--}}

{{--    <!-- Dropdowns Section -->--}}
{{--    <div class="p-4">--}}
{{--        <div class="mb-4">--}}
{{--            <label for="strategic-plan" class="block text-sm font-medium text-gray-700">Select Strategic Plan to Export</label>--}}
{{--            <select id="strategic-plan" name="strategic_plan" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Select Strategic Plan --</option>--}}
{{--                @foreach($strategicPlans as $plan)--}}
{{--                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <form id="export-form" action="{{ url('/export') }}" method="POST" class="p-4">--}}
{{--        @csrf--}}
{{--        <input type="hidden" name="sp_id" id="form-sp-id">--}}

{{--        <div class="flex space-x-4">--}}
{{--            <!-- Asuntos Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-asuntos" name="include_asuntos" checked>--}}
{{--                    <h3 class="text-lg font-bold">Asuntos</h3>--}}
{{--                </label>--}}
{{--                <div id="topics-list" class="space-y-4 ml-7"></div>--}}
{{--            </div>--}}

{{--            <!-- Metas Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-metas" name="include_metas" checked>--}}
{{--                    <h3 class="text-lg font-bold">Metas</h3>--}}
{{--                </label>--}}
{{--                <div id="goals-list" class="space-y-4 ml-7"></div>--}}
{{--            </div>--}}

{{--            <!-- Objetivos Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-objetivos" name="include_objetivos" checked>--}}
{{--                    <h3 class="text-lg font-bold">Objetivos</h3>--}}
{{--                </label>--}}
{{--                <div id="objectives-list" class="space-y-4 ml-7"></div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="mt-6">--}}
{{--            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">--}}
{{--                Generate Excel--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </form>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const toggleSection = (toggle, section) => {--}}
{{--                toggle.addEventListener('change', () => {--}}
{{--                    section.style.display = toggle.checked ? 'block' : 'none';--}}
{{--                });--}}
{{--            }--}}

{{--            toggleSection(toggleAsuntos, topicsList);--}}
{{--            toggleSection(toggleMetas, goalsList);--}}
{{--            toggleSection(toggleObjetivos, objectivesList);--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--</x-layout>--}}

{{--WORKS--}}
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


    {{--    WORKS-ISH--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            // const toggleSection = (toggle, section) => {--}}
{{--            //     toggle.addEventListener('change', () => {--}}
{{--            //         section.style.display = toggle.checked ? 'block' : 'none';--}}
{{--            //     });--}}
{{--            // };--}}
{{--            const toggleSection = (toggle, section) => {--}}
{{--                toggle.addEventListener('change', () => {--}}
{{--                    // Check or uncheck all child checkboxes in that section--}}
{{--                    const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                    checkboxes.forEach(cb => cb.checked = toggle.checked);--}}
{{--                });--}}
{{--            };--}}


{{--            toggleSection(toggleAsuntos, topicsList);--}}
{{--            toggleSection(toggleMetas, goalsList);--}}
{{--            toggleSection(toggleObjetivos, objectivesList);--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                // Automatically check section toggles--}}
{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                topicsList.style.display = 'block';--}}
{{--                goalsList.style.display = 'block';--}}
{{--                objectivesList.style.display = 'block';--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            // New: Track where each goal/objective came from--}}
{{--            const topicGoalMap = new Map(); // topicId -> [goals]--}}
{{--            const goalObjectiveMap = new Map(); // goalId -> [objectives]--}}

{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleAsuntos.checked) {--}}
{{--                    selectedTopics.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedTopics.add(cb.value);--}}
{{--                        cb.onchange = () => handleTopicChange(cb);--}}
{{--                    });--}}
{{--                    loadGoalsFromSelectedTopics();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedTopics.clear();--}}
{{--                    topicGoalMap.clear();--}}
{{--                    goalObjectiveMap.clear();--}}
{{--                    goalsList.innerHTML = '';--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    selectedGoals.clear();--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleMetas.checked) {--}}
{{--                    selectedGoals.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedGoals.add(cb.value);--}}
{{--                        cb.onchange = () => handleGoalChange(cb);--}}
{{--                    });--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedGoals.clear();--}}
{{--                    goalObjectiveMap.clear();--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}
{{--                topicGoalMap.clear();--}}
{{--                goalObjectiveMap.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', () => handleTopicChange(checkbox));--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}

{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function handleTopicChange(cb) {--}}
{{--                if (cb.checked) {--}}
{{--                    selectedTopics.add(cb.value);--}}
{{--                } else {--}}
{{--                    selectedTopics.delete(cb.value);--}}
{{--                    topicGoalMap.delete(cb.value);--}}
{{--                }--}}
{{--                syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                loadGoalsFromSelectedTopics();--}}
{{--            }--}}

{{--            function handleGoalChange(cb) {--}}
{{--                if (cb.checked) {--}}
{{--                    selectedGoals.add(cb.value);--}}
{{--                } else {--}}
{{--                    selectedGoals.delete(cb.value);--}}
{{--                    goalObjectiveMap.delete(cb.value);--}}
{{--                }--}}
{{--                syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                loadObjectivesFromSelectedGoals();--}}
{{--            }--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}
{{--                goalObjectiveMap.clear();--}}

{{--                if (selectedTopics.size === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const fetches = Array.from(selectedTopics).map(id =>--}}
{{--                    fetch(`/reportes/topics/${id}/goals`).then(res => res.json().then(goals => [id, goals]))--}}
{{--                );--}}

{{--                Promise.all(fetches).then(results => {--}}
{{--                    topicGoalMap.clear();--}}
{{--                    const renderedGoalIds = new Set();--}}

{{--                    results.forEach(([topicId, goals]) => {--}}
{{--                        topicGoalMap.set(topicId, goals);--}}

{{--                        goals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', () => handleGoalChange(checkbox));--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (selectedGoals.size === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const fetches = Array.from(selectedGoals).map(id =>--}}
{{--                    fetch(`/reportes/goals/${id}/objectives`).then(res => res.json().then(objs => [id, objs]))--}}
{{--                );--}}

{{--                Promise.all(fetches).then(results => {--}}
{{--                    goalObjectiveMap.clear();--}}
{{--                    const renderedObjectiveIds = new Set();--}}

{{--                    results.forEach(([goalId, objectives]) => {--}}
{{--                        goalObjectiveMap.set(goalId, objectives);--}}

{{--                        objectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', () => {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--Hasta Aqui--}}


{{--    Este repite despues del Parent Test--}}
{{--        <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleAsuntos.checked) {--}}
{{--                    selectedTopics.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedTopics.add(cb.value);--}}

{{--                        cb.onchange = function () {--}}
{{--                            if (this.checked) {--}}
{{--                                selectedTopics.add(cb.value);--}}
{{--                            } else {--}}
{{--                                selectedTopics.delete(cb.value);--}}
{{--                            }--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        };--}}
{{--                    });--}}
{{--                    loadGoalsFromSelectedTopics();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = false;--}}
{{--                        selectedTopics.delete(cb.value);--}}
{{--                    });--}}
{{--                    goalsList.innerHTML = '';--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    selectedGoals.clear();--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleMetas.checked) {--}}
{{--                    selectedGoals.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedGoals.add(cb.value);--}}

{{--                        cb.onchange = function () {--}}
{{--                            if (this.checked) {--}}
{{--                                selectedGoals.add(cb.value);--}}
{{--                            } else {--}}
{{--                                selectedGoals.delete(cb.value);--}}
{{--                            }--}}
{{--                            syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                            loadObjectivesFromSelectedGoals();--}}
{{--                        };--}}
{{--                    });--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = false;--}}
{{--                        selectedGoals.delete(cb.value);--}}
{{--                    });--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}

{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}

{{--                        syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


{{--Repite--}}
{{--        <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleAsuntos.checked) {--}}
{{--                    selectedTopics.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedTopics.add(cb.value);--}}

{{--                        cb.onchange = function () {--}}
{{--                            if (this.checked) {--}}
{{--                                selectedTopics.add(cb.value);--}}
{{--                            } else {--}}
{{--                                selectedTopics.delete(cb.value);--}}
{{--                            }--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        };--}}
{{--                    });--}}
{{--                    loadGoalsFromSelectedTopics();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = false;--}}
{{--                        selectedTopics.delete(cb.value);--}}
{{--                    });--}}
{{--                    goalsList.innerHTML = '';--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    selectedGoals.clear();--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                if (toggleMetas.checked) {--}}
{{--                    selectedGoals.clear();--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedGoals.add(cb.value);--}}

{{--                        cb.onchange = function () {--}}
{{--                            if (this.checked) {--}}
{{--                                selectedGoals.add(cb.value);--}}
{{--                            } else {--}}
{{--                                selectedGoals.delete(cb.value);--}}
{{--                            }--}}
{{--                            syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                            loadObjectivesFromSelectedGoals();--}}
{{--                        };--}}
{{--                    });--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = false;--}}
{{--                        selectedGoals.delete(cb.value);--}}
{{--                    });--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


{{--    Works well but not initially, parent must be toggled first--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            let selectedTopics = new Set();--}}
{{--            let selectedGoals = new Set();--}}

{{--            function syncParentCheckbox(parentCheckbox, container) {--}}
{{--                const checkboxes = container.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = container.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total && total > 0;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            function bindTopicCheckboxes() {--}}
{{--                topicsList.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.addEventListener('change', () => {--}}
{{--                        if (cb.checked) {--}}
{{--                            selectedTopics.add(cb.value);--}}
{{--                        } else {--}}
{{--                            selectedTopics.delete(cb.value);--}}
{{--                        }--}}
{{--                        syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                        loadGoalsFromSelectedTopics();--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}

{{--            function bindGoalCheckboxes() {--}}
{{--                goalsList.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.addEventListener('change', () => {--}}
{{--                        if (cb.checked) {--}}
{{--                            selectedGoals.add(cb.value);--}}
{{--                        } else {--}}
{{--                            selectedGoals.delete(cb.value);--}}
{{--                        }--}}
{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                selectedTopics.clear();--}}
{{--                topicsList.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.checked = toggleAsuntos.checked;--}}
{{--                    if (toggleAsuntos.checked) selectedTopics.add(cb.value);--}}
{{--                });--}}
{{--                syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                loadGoalsFromSelectedTopics();--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                selectedGoals.clear();--}}
{{--                goalsList.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.checked = toggleMetas.checked;--}}
{{--                    if (toggleMetas.checked) selectedGoals.add(cb.value);--}}
{{--                });--}}
{{--                syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                loadObjectivesFromSelectedGoals();--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                objectivesList.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.checked = toggleObjetivos.checked;--}}
{{--                });--}}
{{--                syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const planId = this.value;--}}
{{--                formSpId.value = planId;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                if (planId) {--}}
{{--                    fetch(`/reportes/${planId}`)--}}
{{--                        .then(res => res.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}
{{--                                topicsList.appendChild(wrapper);--}}

{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}

{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            bindTopicCheckboxes();--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIds = Array.from(selectedTopics);--}}
{{--                if (topicIds.length === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const uniqueGoalIds = new Set();--}}

{{--                Promise.all(--}}
{{--                    topicIds.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json()))--}}
{{--                ).then(results => {--}}
{{--                    results.flat().forEach(goal => {--}}
{{--                        if (!uniqueGoalIds.has(goal.g_id)) {--}}
{{--                            uniqueGoalIds.add(goal.g_id);--}}

{{--                            const wrapper = document.createElement('div');--}}
{{--                            wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                            const checkbox = document.createElement('input');--}}
{{--                            checkbox.type = 'checkbox';--}}
{{--                            checkbox.name = 'goals[]';--}}
{{--                            checkbox.value = goal.g_id;--}}
{{--                            checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                            checkbox.checked = true;--}}

{{--                            const label = document.createElement('label');--}}
{{--                            label.textContent = `Meta #${goal.g_num}`;--}}
{{--                            label.className = 'font-medium';--}}

{{--                            wrapper.appendChild(checkbox);--}}
{{--                            wrapper.appendChild(label);--}}
{{--                            goalsList.appendChild(wrapper);--}}

{{--                            selectedGoals.add(goal.g_id);--}}
{{--                        }--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    bindGoalCheckboxes();--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIds = Array.from(selectedGoals);--}}
{{--                if (goalIds.length === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const uniqueObjectiveIds = new Set();--}}

{{--                Promise.all(--}}
{{--                    goalIds.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json()))--}}
{{--                ).then(results => {--}}
{{--                    results.flat().forEach(obj => {--}}
{{--                        if (!uniqueObjectiveIds.has(obj.o_id)) {--}}
{{--                            uniqueObjectiveIds.add(obj.o_id);--}}

{{--                            const wrapper = document.createElement('div');--}}
{{--                            wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                            const checkbox = document.createElement('input');--}}
{{--                            checkbox.type = 'checkbox';--}}
{{--                            checkbox.name = 'objectives[]';--}}
{{--                            checkbox.value = obj.o_id;--}}
{{--                            checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                            checkbox.checked = true;--}}

{{--                            const label = document.createElement('label');--}}
{{--                            label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                            label.className = 'font-medium';--}}

{{--                            wrapper.appendChild(checkbox);--}}
{{--                            wrapper.appendChild(label);--}}
{{--                            objectivesList.appendChild(wrapper);--}}
{{--                        }--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


{{--WORKS POR FIN!!!!!!!!!!!!! YAY WOHOOOOOO--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            // Recalculate sets directly from checkboxes--}}
{{--            function getSelected(container) {--}}
{{--                return new Set(--}}
{{--                    [...container.querySelectorAll('input[type="checkbox"]:checked')].map(cb => cb.value)--}}
{{--                );--}}
{{--            }--}}

{{--            function syncParentCheckbox(parentCheckbox, container) {--}}
{{--                const checkboxes = container.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = container.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total && total > 0;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            function bindCheckboxes(container, onChangeCallback, parentToggle) {--}}
{{--                container.querySelectorAll('input[type="checkbox"]').forEach(cb => {--}}
{{--                    cb.addEventListener('change', () => {--}}
{{--                        onChangeCallback();--}}
{{--                        syncParentCheckbox(parentToggle, container);--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleAsuntos.checked);--}}
{{--                syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                loadGoalsFromSelectedTopics();--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleMetas.checked);--}}
{{--                syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                loadObjectivesFromSelectedGoals();--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--                syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const planId = this.value;--}}
{{--                formSpId.value = planId;--}}

{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (planId) {--}}
{{--                    fetch(`/reportes/${planId}`)--}}
{{--                        .then(res => res.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}
{{--                                topicsList.appendChild(wrapper);--}}
{{--                            });--}}

{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            bindCheckboxes(topicsList, loadGoalsFromSelectedTopics, toggleAsuntos);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                const selectedTopics = getSelected(topicsList);--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (selectedTopics.size === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const seen = new Set();--}}

{{--                Promise.all(--}}
{{--                    [...selectedTopics].map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json()))--}}
{{--                ).then(results => {--}}
{{--                    results.flat().forEach(goal => {--}}
{{--                        if (seen.has(goal.g_id)) return;--}}
{{--                        seen.add(goal.g_id);--}}

{{--                        const wrapper = document.createElement('div');--}}
{{--                        wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                        const checkbox = document.createElement('input');--}}
{{--                        checkbox.type = 'checkbox';--}}
{{--                        checkbox.name = 'goals[]';--}}
{{--                        checkbox.value = goal.g_id;--}}
{{--                        checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                        checkbox.checked = true;--}}

{{--                        const label = document.createElement('label');--}}
{{--                        label.textContent = `Meta #${goal.g_num}`;--}}
{{--                        label.className = 'font-medium';--}}

{{--                        wrapper.appendChild(checkbox);--}}
{{--                        wrapper.appendChild(label);--}}
{{--                        goalsList.appendChild(wrapper);--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    bindCheckboxes(goalsList, loadObjectivesFromSelectedGoals, toggleMetas);--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                const selectedGoals = getSelected(goalsList);--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (selectedGoals.size === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const seen = new Set();--}}

{{--                Promise.all(--}}
{{--                    [...selectedGoals].map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json()))--}}
{{--                ).then(results => {--}}
{{--                    results.flat().forEach(obj => {--}}
{{--                        if (seen.has(obj.o_id)) return;--}}
{{--                        seen.add(obj.o_id);--}}

{{--                        const wrapper = document.createElement('div');--}}
{{--                        wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                        const checkbox = document.createElement('input');--}}
{{--                        checkbox.type = 'checkbox';--}}
{{--                        checkbox.name = 'objectives[]';--}}
{{--                        checkbox.value = obj.o_id;--}}
{{--                        checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                        checkbox.checked = true;--}}

{{--                        const label = document.createElement('label');--}}
{{--                        label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                        label.className = 'font-medium';--}}

{{--                        wrapper.appendChild(checkbox);--}}
{{--                        wrapper.appendChild(label);--}}
{{--                        objectivesList.appendChild(wrapper);--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}



    {{--Parents work, pero no funcionan los childs after parent toggle--}}
{{--        <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            // ✅ Toggle Asuntos--}}
{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}

{{--                if (toggleAsuntos.checked) {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedTopics.add(cb.value);--}}
{{--                    });--}}
{{--                    loadGoalsFromSelectedTopics();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedTopics.clear();--}}
{{--                    goalsList.innerHTML = '';--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    selectedGoals.clear();--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            // ✅ Toggle Metas--}}
{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}

{{--                if (toggleMetas.checked) {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedGoals.add(cb.value);--}}
{{--                    });--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedGoals.clear();--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                }--}}
{{--            });--}}

{{--            // ✅ Toggle Objetivos--}}
{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--            });--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

{{--Parents work, pero no funcionan los childs after parent toggle--}}
{{--        <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            // ✅ Sync parent checkbox state based on children--}}
{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            // ✅ Asuntos toggle--}}
{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}

{{--                if (toggleAsuntos.checked) {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedTopics.add(cb.value);--}}
{{--                    });--}}
{{--                    loadGoalsFromSelectedTopics();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedTopics.clear();--}}
{{--                    goalsList.innerHTML = '';--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                    selectedGoals.clear();--}}
{{--                }--}}
{{--            });--}}

{{--            // ✅ Metas toggle--}}
{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}

{{--                if (toggleMetas.checked) {--}}
{{--                    checkboxes.forEach(cb => {--}}
{{--                        cb.checked = true;--}}
{{--                        selectedGoals.add(cb.value);--}}
{{--                    });--}}
{{--                    loadObjectivesFromSelectedGoals();--}}
{{--                } else {--}}
{{--                    checkboxes.forEach(cb => cb.checked = false);--}}
{{--                    selectedGoals.clear();--}}
{{--                    objectivesList.innerHTML = '';--}}
{{--                }--}}
{{--            });--}}

{{--            // ✅ Objetivos toggle--}}
{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--            });--}}

{{--            // ✅ When plan is selected--}}
{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            // ✅ Load Metas based on selected Asuntos--}}
{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            // ✅ Load Objetivos based on selected Metas--}}
{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


    {{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            // ✅ Parent toggles children + handles cleanup when unchecked--}}
{{--            const toggleSection = (toggle, section, onToggleOff = null) => {--}}
{{--                toggle.addEventListener('change', () => {--}}
{{--                    const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                    checkboxes.forEach(cb => cb.checked = toggle.checked);--}}

{{--                    if (!toggle.checked && typeof onToggleOff === 'function') {--}}
{{--                        onToggleOff();--}}
{{--                    }--}}
{{--                });--}}
{{--            };--}}

{{--            toggleSection(toggleAsuntos, topicsList, () => {--}}
{{--                selectedTopics.clear();--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}
{{--            });--}}

{{--            toggleSection(toggleMetas, goalsList, () => {--}}
{{--                selectedGoals.clear();--}}
{{--                objectivesList.innerHTML = '';--}}
{{--            });--}}

{{--            toggleSection(toggleObjetivos, objectivesList);--}}

{{--            function syncParentCheckbox(parentCheckbox, section) {--}}
{{--                const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                const checked = section.querySelectorAll('input[type="checkbox"]:checked').length;--}}
{{--                const total = checkboxes.length;--}}

{{--                parentCheckbox.checked = checked === total;--}}
{{--                parentCheckbox.indeterminate = checked > 0 && checked < total;--}}
{{--            }--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                // Auto-check toggles--}}
{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                topicsList.appendChild(wrapper);--}}
{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                goalsList.appendChild(wrapper);--}}
{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                                });--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}

{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                        syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}





    {{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdown = document.getElementById('strategic-plan');--}}
{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            const selectedTopics = new Set();--}}
{{--            const selectedGoals = new Set();--}}

{{--            let syncingFromParent = false; // to avoid loop when parent triggers children--}}

{{--            function toggleSection(parentCheckbox, section) {--}}
{{--                parentCheckbox.addEventListener('change', () => {--}}
{{--                    syncingFromParent = true;--}}

{{--                    const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                    checkboxes.forEach(child => {--}}
{{--                        child.checked = parentCheckbox.checked;--}}
{{--                        child.dispatchEvent(new Event('change'));--}}
{{--                    });--}}

{{--                    syncingFromParent = false;--}}
{{--                });--}}
{{--            }--}}

{{--            function setupChildCheckbox(child, parentCheckbox, section) {--}}
{{--                child.addEventListener('change', () => {--}}
{{--                    if (syncingFromParent) return;--}}

{{--                    const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
{{--                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);--}}
{{--                    parentCheckbox.checked = allChecked;--}}
{{--                });--}}
{{--            }--}}

{{--            toggleSection(toggleAsuntos, topicsList);--}}
{{--            toggleSection(toggleMetas, goalsList);--}}
{{--            toggleSection(toggleObjetivos, objectivesList);--}}

{{--            dropdown.addEventListener('change', function () {--}}
{{--                const selectedValue = this.value;--}}
{{--                formSpId.value = selectedValue;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedTopics.clear();--}}
{{--                selectedGoals.clear();--}}

{{--                toggleAsuntos.checked = true;--}}
{{--                toggleMetas.checked = true;--}}
{{--                toggleObjetivos.checked = true;--}}

{{--                topicsList.style.display = 'block';--}}
{{--                goalsList.style.display = 'block';--}}
{{--                objectivesList.style.display = 'block';--}}

{{--                if (selectedValue) {--}}
{{--                    fetch(`/reportes/${selectedValue}`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(topic => {--}}
{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'topics[]';--}}
{{--                                checkbox.value = topic.t_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedTopics.add(topic.t_id);--}}
{{--                                    } else {--}}
{{--                                        selectedTopics.delete(topic.t_id);--}}
{{--                                    }--}}
{{--                                    loadGoalsFromSelectedTopics();--}}
{{--                                });--}}

{{--                                setupChildCheckbox(checkbox, toggleAsuntos, topicsList);--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Asunto #${topic.t_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}
{{--                                topicsList.appendChild(wrapper);--}}

{{--                                selectedTopics.add(topic.t_id);--}}
{{--                            });--}}
{{--                            loadGoalsFromSelectedTopics();--}}
{{--                        });--}}
{{--                }--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics() {--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}
{{--                selectedGoals.clear();--}}

{{--                const topicIdsArray = Array.from(selectedTopics);--}}
{{--                if (topicIdsArray.length === 0) return;--}}

{{--                Promise.all(topicIdsArray.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allGoals = results.flat();--}}
{{--                        const renderedGoalIds = new Set();--}}

{{--                        allGoals.forEach(goal => {--}}
{{--                            if (!renderedGoalIds.has(goal.g_id)) {--}}
{{--                                renderedGoalIds.add(goal.g_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'goals[]';--}}
{{--                                checkbox.value = goal.g_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                checkbox.addEventListener('change', function () {--}}
{{--                                    if (this.checked) {--}}
{{--                                        selectedGoals.add(goal.g_id);--}}
{{--                                    } else {--}}
{{--                                        selectedGoals.delete(goal.g_id);--}}
{{--                                    }--}}
{{--                                    loadObjectivesFromSelectedGoals();--}}
{{--                                });--}}

{{--                                setupChildCheckbox(checkbox, toggleMetas, goalsList);--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Meta #${goal.g_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}
{{--                                goalsList.appendChild(wrapper);--}}

{{--                                selectedGoals.add(goal.g_id);--}}
{{--                            }--}}
{{--                        });--}}

{{--                        loadObjectivesFromSelectedGoals();--}}
{{--                    });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals() {--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                const goalIdsArray = Array.from(selectedGoals);--}}
{{--                if (goalIdsArray.length === 0) return;--}}

{{--                Promise.all(goalIdsArray.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
{{--                    .then(results => {--}}
{{--                        const allObjectives = results.flat();--}}
{{--                        const renderedObjectiveIds = new Set();--}}

{{--                        allObjectives.forEach(obj => {--}}
{{--                            if (!renderedObjectiveIds.has(obj.o_id)) {--}}
{{--                                renderedObjectiveIds.add(obj.o_id);--}}

{{--                                const wrapper = document.createElement('div');--}}
{{--                                wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                                const checkbox = document.createElement('input');--}}
{{--                                checkbox.type = 'checkbox';--}}
{{--                                checkbox.name = 'objectives[]';--}}
{{--                                checkbox.value = obj.o_id;--}}
{{--                                checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}
{{--                                checkbox.checked = true;--}}

{{--                                setupChildCheckbox(checkbox, toggleObjetivos, objectivesList);--}}

{{--                                const label = document.createElement('label');--}}
{{--                                label.textContent = `Objetivo #${obj.o_num}`;--}}
{{--                                label.className = 'font-medium';--}}

{{--                                wrapper.appendChild(checkbox);--}}
{{--                                wrapper.appendChild(label);--}}
{{--                                objectivesList.appendChild(wrapper);--}}
{{--                            }--}}
{{--                        });--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
    {{--    document.addEventListener('DOMContentLoaded', function () {--}}
    {{--        const dropdown = document.getElementById('strategic-plan');--}}
    {{--        const formSpId = document.getElementById('form-sp-id');--}}

    {{--        const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
    {{--        const toggleMetas = document.getElementById('toggle-metas');--}}
    {{--        const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

    {{--        const topicsList = document.getElementById('topics-list');--}}
    {{--        const goalsList = document.getElementById('goals-list');--}}
    {{--        const objectivesList = document.getElementById('objectives-list');--}}

    {{--        const selectedTopics = new Set();--}}
    {{--        const selectedGoals = new Set();--}}

    {{--        // === UTILITIES ===--}}
    {{--        function updateParentState(section, parentCheckbox) {--}}
    {{--            const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
    {{--            const total = checkboxes.length;--}}
    {{--            const checked = Array.from(checkboxes).filter(cb => cb.checked).length;--}}

    {{--            if (checked === total && total > 0) {--}}
    {{--                parentCheckbox.checked = true;--}}
    {{--                parentCheckbox.indeterminate = false;--}}
    {{--            } else if (checked > 0) {--}}
    {{--                parentCheckbox.checked = false;--}}
    {{--                parentCheckbox.indeterminate = true;--}}
    {{--            } else {--}}
    {{--                parentCheckbox.checked = false;--}}
    {{--                parentCheckbox.indeterminate = false;--}}
    {{--            }--}}
    {{--        }--}}

    {{--        function setAllChildren(section, state) {--}}
    {{--            const checkboxes = section.querySelectorAll('input[type="checkbox"]');--}}
    {{--            checkboxes.forEach(cb => {--}}
    {{--                cb.checked = state;--}}
    {{--                cb.dispatchEvent(new Event('change'));--}}
    {{--            });--}}
    {{--        }--}}

    {{--        function resetSection(section, parentCheckbox) {--}}
    {{--            section.innerHTML = '';--}}
    {{--            section.style.display = 'none';--}}
    {{--            parentCheckbox.checked = false;--}}
    {{--            parentCheckbox.indeterminate = false;--}}
    {{--        }--}}

    {{--        // === CASCADE EVENTS ===--}}
    {{--        toggleAsuntos.addEventListener('change', () => setAllChildren(topicsList, toggleAsuntos.checked));--}}
    {{--        toggleMetas.addEventListener('change', () => setAllChildren(goalsList, toggleMetas.checked));--}}
    {{--        toggleObjetivos.addEventListener('change', () => setAllChildren(objectivesList, toggleObjetivos.checked));--}}

    {{--        // === MAIN SELECT CHANGE ===--}}
    {{--        dropdown.addEventListener('change', () => {--}}
    {{--            const spId = dropdown.value;--}}
    {{--            formSpId.value = spId;--}}

    {{--            selectedTopics.clear();--}}
    {{--            selectedGoals.clear();--}}

    {{--            resetSection(topicsList, toggleAsuntos);--}}
    {{--            resetSection(goalsList, toggleMetas);--}}
    {{--            resetSection(objectivesList, toggleObjetivos);--}}

    {{--            if (!spId) return;--}}

    {{--            fetch(`/reportes/${spId}`)--}}
    {{--                .then(res => res.json())--}}
    {{--                .then(data => {--}}
    {{--                    topicsList.style.display = 'block';--}}
    {{--                    data.forEach(topic => {--}}
    {{--                        const div = document.createElement('div');--}}
    {{--                        div.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

    {{--                        const checkbox = document.createElement('input');--}}
    {{--                        checkbox.type = 'checkbox';--}}
    {{--                        checkbox.name = 'topics[]';--}}
    {{--                        checkbox.value = topic.t_id;--}}
    {{--                        checkbox.checked = true;--}}
    {{--                        checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}

    {{--                        checkbox.addEventListener('change', () => {--}}
    {{--                            if (checkbox.checked) {--}}
    {{--                                selectedTopics.add(topic.t_id);--}}
    {{--                            } else {--}}
    {{--                                selectedTopics.delete(topic.t_id);--}}
    {{--                            }--}}
    {{--                            updateParentState(topicsList, toggleAsuntos);--}}
    {{--                            loadGoals();--}}
    {{--                        });--}}

    {{--                        selectedTopics.add(topic.t_id);--}}

    {{--                        const label = document.createElement('label');--}}
    {{--                        label.textContent = `Asunto #${topic.t_num}`;--}}
    {{--                        label.className = 'font-medium';--}}

    {{--                        div.appendChild(checkbox);--}}
    {{--                        div.appendChild(label);--}}
    {{--                        topicsList.appendChild(div);--}}
    {{--                    });--}}

    {{--                    updateParentState(topicsList, toggleAsuntos);--}}
    {{--                    loadGoals();--}}
    {{--                });--}}
    {{--        });--}}

    {{--        function loadGoals() {--}}
    {{--            resetSection(goalsList, toggleMetas);--}}
    {{--            resetSection(objectivesList, toggleObjetivos);--}}
    {{--            selectedGoals.clear();--}}

    {{--            const topicIds = Array.from(selectedTopics);--}}
    {{--            if (topicIds.length === 0) return;--}}

    {{--            goalsList.style.display = 'block';--}}

    {{--            Promise.all(topicIds.map(id => fetch(`/reportes/topics/${id}/goals`).then(res => res.json())))--}}
    {{--                .then(results => {--}}
    {{--                    const allGoals = results.flat();--}}
    {{--                    const uniqueGoals = new Map();--}}

    {{--                    allGoals.forEach(goal => {--}}
    {{--                        if (!uniqueGoals.has(goal.g_id)) {--}}
    {{--                            uniqueGoals.set(goal.g_id, goal);--}}

    {{--                            const div = document.createElement('div');--}}
    {{--                            div.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

    {{--                            const checkbox = document.createElement('input');--}}
    {{--                            checkbox.type = 'checkbox';--}}
    {{--                            checkbox.name = 'goals[]';--}}
    {{--                            checkbox.value = goal.g_id;--}}
    {{--                            checkbox.checked = true;--}}
    {{--                            checkbox.className = 'form-checkbox h-4 w-4 text-green-600';--}}

    {{--                            checkbox.addEventListener('change', () => {--}}
    {{--                                if (checkbox.checked) {--}}
    {{--                                    selectedGoals.add(goal.g_id);--}}
    {{--                                } else {--}}
    {{--                                    selectedGoals.delete(goal.g_id);--}}
    {{--                                }--}}
    {{--                                updateParentState(goalsList, toggleMetas);--}}
    {{--                                loadObjectives();--}}
    {{--                            });--}}

    {{--                            selectedGoals.add(goal.g_id);--}}

    {{--                            const label = document.createElement('label');--}}
    {{--                            label.textContent = `Meta #${goal.g_num}`;--}}
    {{--                            label.className = 'font-medium';--}}

    {{--                            div.appendChild(checkbox);--}}
    {{--                            div.appendChild(label);--}}
    {{--                            goalsList.appendChild(div);--}}
    {{--                        }--}}
    {{--                    });--}}

    {{--                    updateParentState(goalsList, toggleMetas);--}}
    {{--                    loadObjectives();--}}
    {{--                });--}}
    {{--        }--}}

    {{--        function loadObjectives() {--}}
    {{--            resetSection(objectivesList, toggleObjetivos);--}}

    {{--            const goalIds = Array.from(selectedGoals);--}}
    {{--            if (goalIds.length === 0) return;--}}

    {{--            objectivesList.style.display = 'block';--}}

    {{--            Promise.all(goalIds.map(id => fetch(`/reportes/goals/${id}/objectives`).then(res => res.json())))--}}
    {{--                .then(results => {--}}
    {{--                    const allObjectives = results.flat();--}}
    {{--                    const uniqueObjs = new Set();--}}

    {{--                    allObjectives.forEach(obj => {--}}
    {{--                        if (!uniqueObjs.has(obj.o_id)) {--}}
    {{--                            uniqueObjs.add(obj.o_id);--}}

    {{--                            const div = document.createElement('div');--}}
    {{--                            div.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

    {{--                            const checkbox = document.createElement('input');--}}
    {{--                            checkbox.type = 'checkbox';--}}
    {{--                            checkbox.name = 'objectives[]';--}}
    {{--                            checkbox.value = obj.o_id;--}}
    {{--                            checkbox.checked = true;--}}
    {{--                            checkbox.className = 'form-checkbox h-4 w-4 text-purple-600';--}}

    {{--                            checkbox.addEventListener('change', () => {--}}
    {{--                                updateParentState(objectivesList, toggleObjetivos);--}}
    {{--                            });--}}

    {{--                            const label = document.createElement('label');--}}
    {{--                            label.textContent = `Objetivo #${obj.o_num}`;--}}
    {{--                            label.className = 'font-medium';--}}

    {{--                            div.appendChild(checkbox);--}}
    {{--                            div.appendChild(label);--}}
    {{--                            objectivesList.appendChild(div);--}}
    {{--                        }--}}
    {{--                    });--}}

    {{--                    updateParentState(objectivesList, toggleObjetivos);--}}
    {{--                });--}}
    {{--        }--}}
    {{--    });--}}
    {{--</script>--}}





</x-layout>


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
                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }} ({{$plan->sp_years}})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="FY" class="block text-sm font-medium text-gray-700">Select Fiscal Year</label>
            <select id="fiscal-year" name="i_FY" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Select Fiscal Year --</option>
            </select>
        </div>
    </div>
    <form id="export-form" action="{{ url('/export') }}" method="POST" class="p-4">
        @csrf

        <input type="hidden" name="sp_id" id="form-sp-id">
        <input type="hidden" name="i_FY" id="form-fy">

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
                Generar Excel
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownSP = document.getElementById('strategic-plan');
            const dropdownFY = document.getElementById('fiscal-year');

            const topicsList = document.getElementById('topics-list');
            const goalsList = document.getElementById('goals-list');
            const objectivesList = document.getElementById('objectives-list');
            const formSpId = document.getElementById('form-sp-id');
            const formFY = document.getElementById('form-fy');

            const toggleAsuntos = document.getElementById('toggle-asuntos');
            const toggleMetas = document.getElementById('toggle-metas');
            const toggleObjetivos = document.getElementById('toggle-objetivos');

            function getSelected(container) {
                return new Set([...container.querySelectorAll('input[type="checkbox"]:checked')].map(cb => cb.value));
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

            // Load FYs when a Strategic Plan is selected
            dropdownSP.addEventListener('change', function () {
                const spId = this.value;
                formSpId.value = spId;
                formFY.value = '';

                dropdownFY.innerHTML = '<option value="">-- Select Fiscal Year --</option>';
                topicsList.innerHTML = '';
                goalsList.innerHTML = '';
                objectivesList.innerHTML = '';

                if (spId) {
                    fetch(`/reportes/sp/${spId}/fys`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(fy => {
                                const option = document.createElement('option');
                                option.value = fy;
                                option.textContent = fy;
                                dropdownFY.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching FYs:', error));
                }
            });

            // Load checkboxes when FY is selected
            dropdownFY.addEventListener('change', function () {
                const fy = this.value;
                const spId = dropdownSP.value;

                if (!spId || !fy) return;

                formFY.value = fy;
                topicsList.innerHTML = '';
                goalsList.innerHTML = '';
                objectivesList.innerHTML = '';

                fetch(`/reportes/${spId}/${fy}/topics`)
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
                        bindCheckboxes(topicsList, () => loadGoalsFromSelectedTopics(fy), toggleAsuntos);
                        loadGoalsFromSelectedTopics(fy);
                    });
            });

            function loadGoalsFromSelectedTopics(fy) {
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
                    [...selectedTopics].map(id =>
                        fetch(`/reportes/topics/${id}/goals/${fy}`).then(res => res.json())
                    )
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
                    bindCheckboxes(goalsList, () => loadObjectivesFromSelectedGoals(fy), toggleMetas);
                    loadObjectivesFromSelectedGoals(fy);
                });
            }

            function loadObjectivesFromSelectedGoals(fy) {
                const selectedGoals = getSelected(goalsList);
                objectivesList.innerHTML = '';

                if (selectedGoals.size === 0) {
                    syncParentCheckbox(toggleObjetivos, objectivesList);
                    return;
                }

                const seen = new Set();

                Promise.all(
                    [...selectedGoals].map(id =>
                        fetch(`/reportes/goals/${id}/objectives/${fy}`).then(res => res.json())
                    )
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

            // Parent toggles
            toggleAsuntos.addEventListener('change', () => {
                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleAsuntos.checked);
                syncParentCheckbox(toggleAsuntos, topicsList);
                loadGoalsFromSelectedTopics(dropdownFY.value);
            });

            toggleMetas.addEventListener('change', () => {
                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleMetas.checked);
                syncParentCheckbox(toggleMetas, goalsList);
                loadObjectivesFromSelectedGoals(dropdownFY.value);
            });

            toggleObjetivos.addEventListener('change', () => {
                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);
                syncParentCheckbox(toggleObjetivos, objectivesList);
            });
        });
    </script>

</x-layout>

{{--<x-layout>--}}
{{--    <x-slot:heading>--}}
{{--        Reportes--}}
{{--    </x-slot:heading>--}}

{{--    <!-- Dropdowns Section -->--}}
{{--    <div class="p-4">--}}
{{--        <div class="mb-4">--}}
{{--            <label for="strategic-plan" class="block text-sm font-medium text-gray-700">Plan Estratégico para exportar</label>--}}
{{--            <select id="strategic-plan" name="strategic_plan" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Seleccionar Plan Estratégico --</option>--}}
{{--                @foreach($strategicPlans as $plan)--}}
{{--                    <option value="{{ $plan->sp_id }}">{{ $plan->sp_institution }} ({{$plan->sp_years}})</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        --}}{{-- Department Select --}}
{{--        <div class="mb-4">--}}
{{--            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Decanato</label>--}}
{{--            <select name="department" id="department" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Seleccionar Decanato--</option>--}}
{{--                <option>Todos</option>--}}
{{--                <option>Decanato de Administración</option>--}}
{{--                <option>Decanato de Asuntos Académicos</option>--}}
{{--                <option>Decanato de Estudiantes</option>--}}
{{--                <option>Rectoría</option>--}}
{{--                <option>Administración de Empresas</option>--}}
{{--                <option>Artes y Ciencias</option>--}}
{{--                <option>Ciencias Agrícolas</option>--}}
{{--                <option>Ingeniería</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <div class="mb-4">--}}
{{--            <label for="FY" class="block text-sm font-medium text-gray-700">Año Fiscal</label>--}}
{{--            <select id="fiscal-year" name="i_FY" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">--}}
{{--                <option value="">-- Seleccionar Año Fiscal --</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <form id="export-form" action="{{ url('/export') }}" method="POST" class="p-4">--}}
{{--        @csrf--}}
{{--        <input type="hidden" name="sp_id" id="form-sp-id">--}}
{{--        <input type="hidden" name="i_FY" id="form-fy">--}}
{{--        <input type="hidden" name="department" id="form-department">--}}

{{--        <div class="flex space-x-4">--}}
{{--            <!-- Asuntos Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-asuntos" name="include_asuntos">--}}
{{--                    <h3 class="text-lg font-bold">Asuntos</h3>--}}
{{--                </label>--}}
{{--                <button type="button" id="toggle-asuntos-list" class="text-blue-600 hover:underline text-sm mb-2 ml-7">--}}
{{--                    Ver el listado de Asuntos--}}
{{--                </button>--}}
{{--                <div id="topics-list-container" class="hidden ml-7">--}}
{{--                    <div id="topics-list" class="space-y-4"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Metas Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-metas" name="include_metas">--}}
{{--                    <h3 class="text-lg font-bold">Metas</h3>--}}
{{--                </label>--}}
{{--                <button type="button" id="toggle-metas-list" class="text-blue-600 hover:underline text-sm mb-2 ml-7">--}}
{{--                    Ver el listado de Metas--}}
{{--                </button>--}}
{{--                <div id="goals-list-container" class="hidden ml-7">--}}
{{--                    <div id="goals-list" class="space-y-4"></div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Objetivos Section -->--}}
{{--            <div class="flex-1 bg-gray-100 p-4 rounded-lg shadow">--}}
{{--                <label class="flex items-center space-x-2 mb-2">--}}
{{--                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="toggle-objetivos" name="include_objetivos">--}}
{{--                    <h3 class="text-lg font-bold">Objetivos</h3>--}}
{{--                </label>--}}
{{--                <button type="button" id="toggle-objetivos-list" class="text-blue-600 hover:underline text-sm mb-2 ml-7">--}}
{{--                    Ver el listado de Objetivos--}}
{{--                </button>--}}
{{--                <div id="objectives-list-container" class="hidden ml-7">--}}
{{--                    <div id="objectives-list" class="space-y-4"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="mt-6">--}}
{{--            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">--}}
{{--                Generar Excel--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </form>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const dropdownSP = document.getElementById('strategic-plan');--}}
{{--            const dropdownFY = document.getElementById('fiscal-year');--}}
{{--            const dropdownDep = document.getElementById('department');--}}

{{--            const topicsList = document.getElementById('topics-list');--}}
{{--            const goalsList = document.getElementById('goals-list');--}}
{{--            const objectivesList = document.getElementById('objectives-list');--}}
{{--            const formSpId = document.getElementById('form-sp-id');--}}
{{--            const formFY = document.getElementById('form-fy');--}}
{{--            const formDepartment = document.getElementById('form-department');--}}

{{--            const toggleAsuntos = document.getElementById('toggle-asuntos');--}}
{{--            const toggleMetas = document.getElementById('toggle-metas');--}}
{{--            const toggleObjetivos = document.getElementById('toggle-objetivos');--}}

{{--            function getSelected(container) {--}}
{{--                return new Set([...container.querySelectorAll('input[type="checkbox"]:checked')].map(cb => cb.value));--}}
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

{{--            function toggleVisibility(buttonId, containerId, labelText) {--}}
{{--                const button = document.getElementById(buttonId);--}}
{{--                const container = document.getElementById(containerId);--}}

{{--                button.addEventListener('click', () => {--}}
{{--                    const isHidden = container.classList.contains('hidden');--}}
{{--                    container.classList.toggle('hidden');--}}
{{--                    button.textContent = isHidden ? `Ocultar ${labelText}` : `Ver el listado de ${labelText}`;--}}
{{--                });--}}
{{--            }--}}

{{--            toggleVisibility('toggle-asuntos-list', 'topics-list-container', 'Asuntos');--}}
{{--            toggleVisibility('toggle-metas-list', 'goals-list-container', 'Metas');--}}
{{--            toggleVisibility('toggle-objetivos-list', 'objectives-list-container', 'Objetivos');--}}

{{--            dropdownSP.addEventListener('change', function () {--}}
{{--                const spId = this.value;--}}
{{--                formSpId.value = spId;--}}
{{--                formFY.value = '';--}}

{{--                dropdownFY.innerHTML = '<option value="">-- Select Fiscal Year --</option>';--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (spId) {--}}
{{--                    fetch(`/reportes/sp/${spId}/fys`)--}}
{{--                        .then(response => response.json())--}}
{{--                        .then(data => {--}}
{{--                            data.forEach(fy => {--}}
{{--                                const option = document.createElement('option');--}}
{{--                                option.value = fy;--}}
{{--                                option.textContent = fy;--}}
{{--                                dropdownFY.appendChild(option);--}}
{{--                            });--}}
{{--                        })--}}
{{--                        .catch(error => console.error('Error fetching FYs:', error));--}}
{{--                }--}}
{{--            });--}}

{{--            dropdownFY.addEventListener('change', function () {--}}
{{--                const fy = this.value;--}}
{{--                const spId = dropdownSP.value;--}}

{{--                if (!spId || !fy) return;--}}

{{--                formFY.value = fy;--}}
{{--                topicsList.innerHTML = '';--}}
{{--                goalsList.innerHTML = '';--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                fetch(`/reportes/${spId}/${fy}/topics`)--}}
{{--                    .then(res => res.json())--}}
{{--                    .then(data => {--}}
{{--                        data.forEach(topic => {--}}
{{--                            const wrapper = document.createElement('div');--}}
{{--                            wrapper.className = 'flex items-center space-x-2 text-sm text-gray-700';--}}

{{--                            const checkbox = document.createElement('input');--}}
{{--                            checkbox.type = 'checkbox';--}}
{{--                            checkbox.name = 'topics[]';--}}
{{--                            checkbox.value = topic.t_id;--}}
{{--                            checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';--}}
{{--                            checkbox.checked = true;--}}

{{--                            const label = document.createElement('label');--}}
{{--                            label.textContent = `Asunto ${topic.t_num}`;--}}
{{--                            label.className = 'font-medium';--}}

{{--                            wrapper.appendChild(checkbox);--}}
{{--                            wrapper.appendChild(label);--}}
{{--                            topicsList.appendChild(wrapper);--}}
{{--                        });--}}

{{--                        syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                        bindCheckboxes(topicsList, () => loadGoalsFromSelectedTopics(fy), toggleAsuntos);--}}
{{--                        loadGoalsFromSelectedTopics(fy);--}}
{{--                    });--}}
{{--            });--}}

{{--            function loadGoalsFromSelectedTopics(fy) {--}}
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
{{--                    [...selectedTopics].map(id =>--}}
{{--                        fetch(`/reportes/topics/${id}/goals/${fy}`).then(res => res.json())--}}
{{--                    )--}}
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
{{--                        label.textContent = `Meta ${goal.g_num}`;--}}
{{--                        label.className = 'font-medium';--}}

{{--                        wrapper.appendChild(checkbox);--}}
{{--                        wrapper.appendChild(label);--}}
{{--                        goalsList.appendChild(wrapper);--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                    bindCheckboxes(goalsList, () => loadObjectivesFromSelectedGoals(fy), toggleMetas);--}}
{{--                    loadObjectivesFromSelectedGoals(fy);--}}
{{--                });--}}
{{--            }--}}

{{--            function loadObjectivesFromSelectedGoals(fy) {--}}
{{--                const selectedGoals = getSelected(goalsList);--}}
{{--                objectivesList.innerHTML = '';--}}

{{--                if (selectedGoals.size === 0) {--}}
{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const seen = new Set();--}}

{{--                Promise.all(--}}
{{--                    [...selectedGoals].map(id =>--}}
{{--                        fetch(`/reportes/goals/${id}/objectives/${fy}`).then(res => res.json())--}}
{{--                    )--}}
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
{{--                        label.textContent = `Objetivo ${obj.t_num}.${obj.g_num}.${obj.o_num}`;--}}
{{--                        label.className = 'font-medium';--}}

{{--                        wrapper.appendChild(checkbox);--}}
{{--                        wrapper.appendChild(label);--}}
{{--                        objectivesList.appendChild(wrapper);--}}
{{--                    });--}}

{{--                    syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--                    bindCheckboxes(objectivesList, () => {}, toggleObjetivos);--}}
{{--                });--}}
{{--            }--}}

{{--            toggleAsuntos.addEventListener('change', () => {--}}
{{--                const checkboxes = topicsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleAsuntos.checked);--}}
{{--                syncParentCheckbox(toggleAsuntos, topicsList);--}}
{{--                loadGoalsFromSelectedTopics(dropdownFY.value);--}}
{{--            });--}}

{{--            toggleMetas.addEventListener('change', () => {--}}
{{--                const checkboxes = goalsList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleMetas.checked);--}}
{{--                syncParentCheckbox(toggleMetas, goalsList);--}}
{{--                loadObjectivesFromSelectedGoals(dropdownFY.value);--}}
{{--            });--}}

{{--            toggleObjetivos.addEventListener('change', () => {--}}
{{--                const checkboxes = objectivesList.querySelectorAll('input[type="checkbox"]');--}}
{{--                checkboxes.forEach(cb => cb.checked = toggleObjetivos.checked);--}}
{{--                syncParentCheckbox(toggleObjetivos, objectivesList);--}}
{{--            });--}}

{{--            const exportForm = document.getElementById('export-form');--}}

{{--            exportForm.addEventListener('submit', function () {--}}
{{--                formDepartment.value = dropdownDep.value;--}}

{{--            });--}}

{{--        });--}}

{{--    </script>--}}
{{--</x-layout>--}}

<x-layout>
    <x-slot:heading>
        Solicitudes de Acceso
    </x-slot:heading>

    @php
        $roleTranslations = [
            'Admin' => 'Administrador',
            'Planner' => 'Planificador',
            'Contributor' => 'Colaborador',
            'Assignee' => 'Asignado',
            'Viewer' => 'Visitante',
        ];
    @endphp

    @if(session('success'))
        <div id="success-message"
             class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <div class="px-6 py-4">
        @if($requests->isEmpty())
            <p class="text-gray-600">No hay solicitudes pendientes en este momento.</p>
        @else
            {{-- Table --}}
            <div class="flex justify-end mb-4 gap-3">
                <button type="button"
                        onclick="showConfirmModal()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Aprobar Seleccionados
                </button>
                <button type="button"
                        onclick="showRejectModal()"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Rechazar Seleccionados
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2">
                            <input type="checkbox" onclick="toggleAll(this)">
                        </th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Decanato</th>
                        <th class="px-4 py-2">Rol Solicitado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <input type="checkbox"
                                       name="selected_requests[]"
                                       form="bulk-approve-form"
                                       value="{{ $request->id }}"
                                       data-user="{{ $request->user->u_fname }} {{ $request->user->u_lname }}"
                                       data-role="{{ $request->requested_role }}">
                            </td>
                            <td class="px-4 py-2">{{ $request->user->u_fname }} {{ $request->user->u_lname }}</td>
                            <td class="px-4 py-2">{{ $request->user->email }}</td>
                            <td class="px-4 py-2">{{ $request->department }}</td>
                            <td class="px-4 py-2">{{ $roleTranslations[$request->requested_role] ?? $request->requested_role }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <form method="POST" onsubmit="event.preventDefault(); confirmSingleApprove({{ $request->id }}, '{{ $request->user->u_fname }} {{ $request->user->u_lname }}', '{{ $request->requested_role }}');">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                        Aprobar
                                    </button>
                                </form>
                                <form method="POST" onsubmit="event.preventDefault(); confirmSingleReject({{ $request->id }}, '{{ $request->user->u_fname }} {{ $request->user->u_lname }}', '{{ $request->requested_role }}');">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Rechazar
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Separated Forms --}}
            <form id="bulk-approve-form" method="POST" action="{{ route('role-requests.approveBulk') }}">
                @csrf
            </form>

            <form id="bulk-reject-form" method="POST" action="{{ route('role-requests.rejectBulk') }}">
                @csrf
            </form>
        @endif
    </div>

    {{-- Modals --}}
    <div id="confirm-modal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Confirmar Aprobación</h2>
            <p class="mb-4 text-gray-700">Estás a punto de aprobar acceso para los siguientes usuarios:</p>
            <ul id="selected-users" class="list-disc list-inside text-gray-600 mb-6"></ul>
            <div class="flex justify-end gap-3">
                <button onclick="hideConfirmModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar
                </button>
                <button onclick="submitBulkApproval()"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Confirmar
                </button>
            </div>
        </div>
    </div>

    <div id="reject-modal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Confirmar Rechazo</h2>
            <p class="mb-4 text-gray-700">Estás a punto de <span class="text-red-600 font-semibold">rechazar</span> acceso para los siguientes usuarios:</p>
            <ul id="rejected-users" class="list-disc list-inside text-gray-600 mb-6"></ul>
            <div class="flex justify-end gap-3">
                <button onclick="hideRejectModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar
                </button>
                <button onclick="submitBulkRejection()"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Confirmar
                </button>
            </div>
        </div>
    </div>
    <!-- Single Approve Modal -->
    <div id="single-approve-modal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Confirmar Aprobación</h2>
            <p class="mb-4 text-gray-700" id="single-approve-text"></p>
            <form id="single-approve-form" method="POST">
                @csrf
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="hideSingleApproveModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar</button>
                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Single Reject Modal -->
    <div id="single-reject-modal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Confirmar Rechazo</h2>
            <p class="mb-4 text-gray-700" id="single-reject-text"></p>
            <form id="single-reject-form" method="POST">
                @csrf
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="hideSingleRejectModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancelar</button>
                    <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Confirmar</button>
                </div>
            </form>
        </div>
    </div>



    {{-- Scripts --}}
    <script>
        const roleTranslations = {!! json_encode([
        'Admin' => 'Administrador',
        'Planner' => 'Planificador',
        'Contributor' => 'Colaborador',
        'Assignee' => 'Asignado',
        'Viewer' => 'Visualizador',
    ]) !!};
    </script>


    <script>
        function toggleAll(masterCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="selected_requests[]"]');
            checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        }

        function showConfirmModal() {
            const selected = document.querySelectorAll('input[name="selected_requests[]"]:checked');
            const list = document.getElementById('selected-users');
            list.innerHTML = '';

            if (selected.length === 0) {
                alert('Por favor selecciona al menos un usuario.');
                return;
            }

            selected.forEach(cb => {
                const name = cb.dataset.user;
                const role = cb.dataset.role;
                const translatedRole = roleTranslations[role] ?? role;
                const li = document.createElement('li');
                li.textContent = `${name} - ${translatedRole}`;
                list.appendChild(li);
            });

            document.getElementById('confirm-modal').classList.remove('hidden');
        }


        function hideConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }

        function submitBulkApproval() {
            document.getElementById('bulk-approve-form').submit();
        }

        function showRejectModal() {
            const selected = document.querySelectorAll('input[name="selected_requests[]"]:checked');
            const list = document.getElementById('rejected-users');
            list.innerHTML = '';
            document.getElementById('bulk-reject-form').innerHTML = `@csrf`;

            if (selected.length === 0) {
                alert('Por favor selecciona al menos un usuario.');
                return;
            }

            selected.forEach(cb => {
                const name = cb.dataset.user;
                const role = cb.dataset.role;
                const translatedRole = roleTranslations[role] ?? role;
                const li = document.createElement('li');
                li.textContent = `${name} - ${translatedRole}`;
                list.appendChild(li);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_requests[]';
                input.value = cb.value;
                document.getElementById('bulk-reject-form').appendChild(input);
            });

            document.getElementById('reject-modal').classList.remove('hidden');
        }


        function hideRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
        }

        function submitBulkRejection() {
            document.getElementById('bulk-reject-form').submit();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const msg = document.getElementById('success-message');
            if (msg) {
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 4000);
            }
        });
    </script>

    <script>
        function confirmSingleApprove(id, name, role) {
            const form = document.getElementById('single-approve-form');
            form.action = `/roles/requests/${id}/approve`; // assumes RESTful URL pattern
            document.getElementById('single-approve-text').innerHTML =
                `Estás a punto de <strong>aprobar</strong> acceso para <strong>${name}</strong> como <strong>${roleTranslations[role] ?? role}</strong>.`;
            document.getElementById('single-approve-modal').classList.remove('hidden');
        }

        function hideSingleApproveModal() {
            document.getElementById('single-approve-modal').classList.add('hidden');
        }

        function confirmSingleReject(id, name, role) {
            const form = document.getElementById('single-reject-form');
            form.action = `/roles/requests/${id}/reject`;
            document.getElementById('single-reject-text').innerHTML =
                `Estás a punto de <strong>rechazar</strong> acceso para <strong>${name}</strong> como <strong>${roleTranslations[role] ?? role}</strong>.`;
            document.getElementById('single-reject-modal').classList.remove('hidden');
        }

        function hideSingleRejectModal() {
            document.getElementById('single-reject-modal').classList.add('hidden');
        }
    </script>

</x-layout>

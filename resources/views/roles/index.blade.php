<x-layout>
    <x-slot:heading>
        Solicitudes de Acceso
    </x-slot:heading>

    {{-- Role name translations for display --}}
    @php
        $roleTranslations = [
            'Admin' => 'Administrador',
            'Planner' => 'Planificador',
            'Contributor' => 'Colaborador',
            'Assignee' => 'Asignado',
            'Viewer' => 'Visitante',
        ];
    @endphp

    {{-- Success message toast --}}
    @if(session('success'))
        <div id="success-message"
             class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <div class="px-6 py-4">
        {{-- No pending requests --}}
        @if($requests->isEmpty())
            <p class="text-gray-600">No hay solicitudes pendientes en este momento.</p>
        @else

            {{-- Bulk action buttons --}}
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

            {{-- Requests Table --}}
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
                            {{-- Checkbox with metadata for modals --}}
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

                            {{-- Individual Approve/Reject buttons --}}
                            <td class="px-4 py-2 flex gap-2">
                                <form action="{{ route('roles.requests.approve', $request) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                        Aprobar
                                    </button>
                                </form>
                                <form action="{{ route('roles.requests.reject', $request) }}" method="POST">
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

            {{-- Bulk Approve & Reject forms --}}
            <form id="bulk-approve-form" method="POST" action="{{ route('role-requests.approveBulk') }}">
                @csrf
            </form>

            <form id="bulk-reject-form" method="POST" action="{{ route('role-requests.rejectBulk') }}">
                @csrf
            </form>
        @endif
    </div>

    {{-- Confirm Approval Modal --}}
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

    {{-- Confirm Rejection Modal --}}
    <div id="reject-modal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Confirmar Rechazo</h2>
            <p class="mb-4 text-gray-700">Estás a punto de <span class="text-red-600 font-semibold">rechazar</span> acceso para los siguientes usuarios:</p>
            <ul id="rejected-users" class="list-disc list-inside text-gray-600 mb-6"></ul>
            <div class="flex justify-end gap-3">
                <button onclick="hideRejectModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">

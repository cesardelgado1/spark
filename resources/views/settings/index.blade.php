<x-layout>
    <x-slot:heading>
        Usuario y Roles
    </x-slot:heading>

    {{-- AlpineJS tab state --}}
    <div class="max-w-7xl mx-auto px-4 py-6" x-data="{ tab: '{{ $activeTab }}' }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Configuraciones</h1>

        {{-- Navigation Tabs --}}
        <div class="flex border-b mb-4">
            <button @click="tab = 'roles'" class="px-4 py-2 font-medium border-b-2"
                    :class="tab === 'roles' ? 'border-blue-600 text-blue-600' : 'text-gray-500'">
                Roles
            </button>
            <button @click="tab = 'logs'" class="px-4 py-2 font-medium border-b-2"
                    :class="tab === 'logs' ? 'border-blue-600 text-blue-600' : 'text-gray-500'">
                Logs
            </button>
        </div>

        {{-- ROLES TAB --}}
        <div x-show="tab === 'roles'">
            {{-- Search by email --}}
            <form method="GET" action="{{ route('settings.index') }}" class="mb-4">
                <input type="text" name="search" placeholder="Search by email..."
                       value="{{ $search }}"
                       class="border rounded px-4 py-2 w-64">
                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Search
                </button>
            </form>

            {{-- Users Table with Role Management --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Apellido</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $user->u_fname }}</td>
                            <td class="px-4 py-3">{{ $user->u_lname }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $roleTranslations = [
                                        'Admin' => 'Administrador',
                                        'Planner' => 'Planificador',
                                        'Contributor' => 'Colaborador',
                                        'Assignee' => 'Asignado',
                                        'Viewer' => 'Visitante',
                                    ];
                                @endphp

                                {{-- Role dropdown per user --}}
                                <select
                                    id="role-select-{{ $user->id }}"
                                    data-current-role="{{ $user->u_type }}"
                                    onchange="handleRoleChange('{{ $user->id }}', this.dataset.currentRole, '{{ $user->u_fname }} {{ $user->u_lname }}')"
                                    class="border border-gray-300 rounded px-2 py-1"
                                >
                                    @foreach($roleTranslations as $english => $spanish)
                                        <option value="{{ $english }}" @if($user->u_type === $english) selected @endif>
                                            {{ $spanish }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination for users --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        {{-- LOGS TAB --}}
        <div x-show="tab === 'logs'" x-cloak class="space-y-8">

            {{-- Filter logs by email --}}
            <form method="GET" action="{{ route('settings.index') }}" class="mb-4">
                <input type="hidden" name="tab" value="logs">
                <label class="mr-2 font-medium">Busca en el registro por email:</label>
                <input type="text" name="log_search" placeholder="e.g. user@example.com"
                       value="{{ $logSearch }}"
                       class="border rounded px-2 py-1 w-64">
                <button type="submit" class="ml-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Search
                </button>
            </form>

            {{-- Audit Logs Table --}}
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Actividad Reciente (Audit Logs)</h2>
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Actión</th>
                            <th class="px-4 py-3">Parametro</th>
                            <th class="px-4 py-3">Creado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($auditLogs as $log)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $log->user->email ?? 'System' }}</td>
                                <td class="

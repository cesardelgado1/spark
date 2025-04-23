<x-layout>
    <x-slot:heading>
        Usuario y Roles
    </x-slot:heading>
    <div class="max-w-7xl mx-auto px-4 py-6" x-data="{ tab: '{{ $activeTab }}' }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Settings</h1>
        {{-- Tabs --}}
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
            {{-- Search --}}
            <form method="GET" action="{{ route('settings.index') }}" class="mb-4">
                <input type="text" name="search" placeholder="Search by email..."
                       value="{{ $search }}"
                       class="border rounded px-4 py-2 w-64">
                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Search
                </button>
            </form>

            {{-- Users Table --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">First Name</th>
                        <th class="px-4 py-3">Last Name</th>
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
                                <select
                                    id="role-select-{{ $user->id }}"
                                    data-current-role="{{ $user->u_type }}"
                                    onchange="handleRoleChange('{{ $user->id }}', this.dataset.currentRole, '{{ $user->u_fname }} {{ $user->u_lname }}')"
                                    class="border border-gray-300 rounded px-2 py-1"
                                >
                                    @foreach(['Admin', 'Planner', 'Contributor', 'Assignee'] as $role)
                                        <option value="{{ $role }}" @if($user->u_type === $role) selected @endif>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        {{-- LOGS TAB --}}
        <div x-show="tab === 'logs'" x-cloak class="space-y-8">

            {{-- Filter by email --}}
            <form method="GET" action="{{ route('settings.index') }}" class="mb-4">
                <input type="hidden" name="tab" value="logs">
                <label class="mr-2 font-medium">Search logs by user email:</label>
                <input type="text" name="log_search" placeholder="e.g. user@example.com"
                       value="{{ $logSearch }}"
                       class="border rounded px-2 py-1 w-64">
                <button type="submit" class="ml-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Search
                </button>
            </form>
            {{-- Audit Logs --}}
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Recent Activity (Audit Logs)</h2>
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Action</th>
                            <th class="px-4 py-3">Parameter</th>
                            <th class="px-4 py-3">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($auditLogs as $log)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $log->user->email ?? 'System' }}</td>
                                <td class="px-4 py-3">{{ $log->al_action }}</td>
                                <td class="px-4 py-3">{{ $log->al_action_par ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-3 text-gray-500" colspan="4">No recent activity found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Active Sessions --}}
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-2">Active Sessions</h2>
                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">IP Address</th>
                            <th class="px-4 py-3">User Agent</th>
                            <th class="px-4 py-3">Last Activity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($sessions as $session)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $session->email }}</td>
                                <td class="px-4 py-3">{{ $session->ip_address }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $session->user_agent }}">
                                    {{ Str::limit($session->user_agent, 50) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-3 text-gray-500" colspan="4">No active sessions.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-layout>
<!-- Success Toast (Centered Top) -->
<div id="success-toast"
     class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50">
    <span id="success-toast-message">¡Rol actualizado correctamente!</span>
</div>

<!-- Confirmation Modal -->
<div id="role-confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg max-w-md w-full p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Confirmar cambio de rol</h2>
        <p class="text-gray-700 mb-2">
            Estás a punto de cambiar el rol de
            <span class="font-semibold" id="confirm-user-name"></span>
            de
            <span class="font-semibold text-red-500" id="current-role"></span>
            a
            <span class="font-semibold text-green-600" id="new-role"></span>.
        </p>
        <div class="flex justify-end gap-3 mt-6">
            <button onclick="cancelRoleChange()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Cancelar
            </button>
            <button onclick="confirmRoleChange()" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                Confirmar
            </button>
        </div>
    </div>
</div>
<script>
    let selectedUserId = null;
    let newRole = null;
    let currentRole = null;
    let userName = null;

    function handleRoleChange(userId, current, fullName) {
        const select = document.getElementById(`role-select-${userId}`);
        const selectedValue = select.value;

        selectedUserId = userId;
        newRole = selectedValue;
        currentRole = current;
        userName = fullName;

        // Update modal text
        document.getElementById('confirm-user-name').textContent = userName;
        document.getElementById('current-role').textContent = currentRole;
        document.getElementById('new-role').textContent = newRole;

        // Show modal
        document.getElementById('role-confirm-modal').classList.remove('hidden');
    }

    function cancelRoleChange() {
        document.getElementById('role-confirm-modal').classList.add('hidden');
        const select = document.getElementById(`role-select-${selectedUserId}`);
        select.value = currentRole; // Reset dropdown
        selectedUserId = null;
        newRole = null;
        currentRole = null;
    }

    function confirmRoleChange() {
        document.getElementById('role-confirm-modal').classList.add('hidden');

        fetch(`/configuracion/role-usuario/${selectedUserId}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ u_type: newRole })
        }).then(response => {
            if (response.ok) {
                // Update memory and dataset
                const select = document.getElementById(`role-select-${selectedUserId}`);
                select.setAttribute('data-current-role', newRole);
                currentRole = newRole;

                // ✅ Show toast
                showSuccessToast(`Rol de ${userName} cambiado a ${newRole}`);
            } else {
                alert('Hubo un error al actualizar el rol.');
            }

            // Reset
            selectedUserId = null;
            newRole = null;
        });
    }
    function showSuccessToast(message) {
        const toast = document.getElementById('success-toast');
        const toastMsg = document.getElementById('success-toast-message');

        toastMsg.textContent = message;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 4000);
    }

</script>


{{-- AlpineJS CDN (if not already included) --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

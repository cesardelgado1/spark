<x-layout>
    <x-slot:heading>
        Solicitudes de Acceso
    </x-slot:heading>

    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="px-6 py-4">
        @if($requests->isEmpty())
            <p class="text-gray-600">No hay solicitudes pendientes en este momento.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Departamento</th>
                        <th class="px-4 py-2">Rol Solicitado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $request->user->u_fname }} {{ $request->user->u_lname }}</td>
                            <td class="px-4 py-2">{{ $request->user->email }}</td>
                            <td class="px-4 py-2">{{ $request->department }}</td>
                            <td class="px-4 py-2">{{ $request->requested_role }}</td>
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
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 4000);
            }
        });
    </script>
</x-layout>

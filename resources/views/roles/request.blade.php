<x-layout>
    <x-slot:heading>
        Solicitar Acceso
    </x-slot:heading>

    <div class="max-w-3xl mx-auto p-6">
        @if(session('success'))
            <div id="success-message"
                 class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif

        {{-- PENDING REQUEST --}}
        @if($existingRequest && $existingRequest->status === 'Pending')
            <div class="bg-yellow-100 border border-yellow-300 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tu solicitud está pendiente</h2>
                <p class="mb-2"><strong>Nombre:</strong> {{ auth()->user()->u_fname }} {{ auth()->user()->u_lname }}</p>
                <p class="mb-2"><strong>Correo:</strong> {{ auth()->user()->email }}</p>
                <p class="mb-2"><strong>Decanato:</strong> {{ $existingRequest->department }}</p>
                <p class="mb-2"><strong>Rol Solicitado:</strong> {{ $existingRequest->requested_role }}</p>
                <p class="mb-2"><strong>Estado:</strong> <span class="font-semibold text-yellow-800">{{ $existingRequest->status }}</span></p>

                {{-- Edit Form --}}
                <form method="POST" action="{{ route('roles.requests.update', $existingRequest) }}" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="department" class="block font-medium text-gray-700">Decanato</label>
                        <select name="department" id="department" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">-- Selecciona un decanato --</option>
                            @foreach(['Ingeniería','Rectoría','Artes y Ciencias','Administración de Empresas','Ciencias Agrícolas','Decanato de Administración','Decanato de Asuntos Académicos','Decanato de Estudiantes'] as $dep)
                                <option value="{{ $dep }}" @if($existingRequest->department === $dep) selected @endif>{{ $dep }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="requested_role" class="block font-medium text-gray-700">Rol Solicitado</label>
                        <select name="requested_role" id="requested_role" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">-- Selecciona un rol --</option>
                            @foreach(['Assignee', 'Contributor', 'Planner'] as $role)
                                <option value="{{ $role }}" @if($existingRequest->requested_role === $role) selected @endif>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Actualizar Solicitud
                        </button>
                    </div>
                </form>
            </div>
            {{-- REJECTED REQUEST --}}
            @elseif($existingRequest && $existingRequest->status === 'Rejected')
                <div class="bg-red-100 border border-red-300 p-6 rounded-lg shadow" id="rejected-box">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tu solicitud fue rechazada</h2>
                    <p class="mb-2"><strong>Nombre:</strong> {{ auth()->user()->u_fname }} {{ auth()->user()->u_lname }}</p>
                    <p class="mb-2"><strong>Correo:</strong> {{ auth()->user()->email }}</p>
                    <p class="mb-2"><strong>Decanato:</strong> {{ $existingRequest->department }}</p>
                    <p class="mb-2"><strong>Rol Solicitado:</strong> {{ $existingRequest->requested_role }}</p>
                    <p class="mb-2"><strong>Estado:</strong> <span class="font-semibold text-red-800">Rechazado</span></p>

                    <div class="mt-4">
                        <button onclick="showNewRequestForm()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Hacer nueva solicitud
                        </button>
                    </div>
                </div>

                {{-- Hidden new request form --}}
                <form method="POST" action="{{ route('roles.request.submit') }}"
                      id="new-request-form" class="hidden mt-6 bg-white shadow-md border border-gray-300 rounded-lg p-6 space-y-6">
                    @csrf

                    <div>
                        <label for="department" class="block font-medium text-gray-700">Decanato</label>
                        <select name="department" id="department" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">-- Selecciona un decanato --</option>
                            @foreach(['Ingeniería','Rectoría','Artes y Ciencias','Administración de Empresas','Ciencias Agrícolas','Decanato de Administración','Decanato de Asuntos Académicos','Decanato de Estudiantes'] as $dep)
                                <option value="{{ $dep }}">{{ $dep }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="requested_role" class="block font-medium text-gray-700">Rol Solicitado</label>
                        <select name="requested_role" id="requested_role" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">-- Selecciona un rol --</option>
                            <option value="Assignee">Assignee</option>
                            <option value="Contributor">Contributor</option>
                            <option value="Planner">Planner</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>

                <script>
                    function showNewRequestForm() {
                        document.getElementById('rejected-box').classList.add('hidden');
                        document.getElementById('new-request-form').classList.remove('hidden');
                    }
                </script>

                {{-- NEW REQUEST --}}
        @else
            <form method="POST" action="{{ route('roles.request.submit') }}" class="bg-white shadow-md border border-gray-300 rounded-lg p-6 space-y-6">
                @csrf

                <div>
                    <label for="department" class="block font-medium text-gray-700">Decanato</label>
                    <select name="department" id="department" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">-- Selecciona un decanato --</option>
                        @foreach(['Ingeniería','Rectoría','Artes y Ciencias','Administración de Empresas','Ciencias Agrícolas','Decanato de Administración','Decanato de Asuntos Académicos','Decanato de Estudiantes'] as $dep)
                            <option value="{{ $dep }}">{{ $dep }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="requested_role" class="block font-medium text-gray-700">Rol Solicitado</label>
                    <select name="requested_role" id="requested_role" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">-- Selecciona un rol --</option>
                        <option value="Assignee">Assignee</option>
                        <option value="Contributor">Contributor</option>
                        <option value="Planner">Planner</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        @endif
    </div>
    <div class="mt-8 border-t pt-6 ml-9">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Permisos por rol en SPARK</h3>

        <div class="space-y-4">
            <div class="bg-gray-100 p-4 rounded-lg border-l-4 border-indigo-500">
                <h4 class="font-semibold text-indigo-700">Assignee (Asignado)</h4>
                <ul class="list-disc list-inside text-gray-700 mt-2">
                    <li>Puede acceder a los objetivos que le han sido asignados.</li>
                    <li>Puede llenar los indicadores correspondientes (texto, número o documentos).</li>
                    <li>No puede modificar la estructura del plan estratégico.</li>
                </ul>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg border-l-4 border-green-500">
                <h4 class="font-semibold text-green-700">Contributor (Contribuidor)</h4>
                <ul class="list-disc list-inside text-gray-700 mt-2">
                    <li>Puede ver todos los objetivos que le ha asignado un Planificador.</li>
                    <li>Puede reasignar indicadores a usuarios con rol de Asignado.</li>
                    <li>No puede crear o editar temas, metas u objetivos.</li>
                </ul>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg border-l-4 border-yellow-500">
                <h4 class="font-semibold text-yellow-700">Planner (Planificador)</h4>
                <ul class="list-disc list-inside text-gray-700 mt-2">
                    <li>Puede crear, editar y eliminar temas, metas, objetivos e indicadores.</li>
                    <li>Puede asignar objetivos a Contribuidores y gestionar tareas.</li>
                    <li>Puede aprobar o rechazar solicitudes de acceso de nuevos usuarios.</li>
                </ul>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const msg = document.getElementById('success-message');
            if (msg) {
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 4000);
            }
        });
    </script>
</x-layout>

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

        @if($existingRequest)
            {{-- Request Already Exists --}}
            <div class="bg-yellow-100 border border-yellow-300 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tu solicitud está pendiente</h2>
                <p class="mb-2"><strong>Nombre:</strong> {{ auth()->user()->u_fname }} {{ auth()->user()->u_lname }}</p>
                <p class="mb-2"><strong>Correo:</strong> {{ auth()->user()->email }}</p>
                <p class="mb-2"><strong>Departamento:</strong> {{ $existingRequest->department }}</p>
                <p class="mb-2"><strong>Rol Solicitado:</strong> {{ $existingRequest->requested_role }}</p>
                <p class="mb-2"><strong>Estado:</strong> <span class="font-semibold text-yellow-800">Pendiente</span></p>

                {{-- Edit Button --}}
                <form method="POST" action="{{ route('roles.requests.update', $existingRequest) }}" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="department" class="block font-medium text-gray-700">Decanato</label>
                        <select name="department" id="department" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Selecciona un departamento --</option>
                            <option value="Ingeniería">Ingeniería</option>
                            <option value="Rectoría">Rectoría</option>
                            <option value="Artes y Ciencias">Artes y Ciencias</option>
                            <option value="Administración de Empresas">Administración de Empresas</option>
                            <option value="Ciencias Agrícolas">Ciencias Agrícolas</option>
                            <option value="Decanato de Administración">Decanato de Administración</option>
                            <option value="Decanato de Asuntos Académicos">Decanato de Asuntos Académicos</option>
                            <option value="Decanato de Estudiantes">Decanato de Estudiantes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="requested_role" class="block font-medium text-gray-700">Rol Solicitado</label>
                        <select name="requested_role" id="requested_role" required
                                class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Selecciona un rol --</option>
                            <option value="Assignee">Assignee</option>
                            <option value="Contributor">Contributor</option>
                            <option value="Planner">Planner</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Actualizar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        @else
            {{-- Submit New Request --}}
            <form method="POST" action="{{ route('roles.request.submit') }}"
                  class="bg-white shadow-md border border-gray-300 rounded-lg p-6 space-y-6">
                @csrf

                <div>
                    <label for="department" class="block font-medium text-gray-700">Departamento</label>
                    <select name="department" id="department" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:outline-none">
                        <option value="">-- Selecciona un departamento --</option>
                        <option value="Ingeniería">Ingeniería</option>
                        <option value="Rectoría">Rectoría</option>
                        <option value="Artes y Ciencias">Artes y Ciencias</option>
                        <option value="Administración de Empresas">Administración de Empresas</option>
                        <option value="Ciencias Agrícolas">Ciencias Agrícolas</option>
                        <option value="Decanato de Administración">Decanato de Administración</option>
                        <option value="Decanato de Asuntos Académicos">Decanato de Asuntos Académicos</option>
                        <option value="Decanato de Estudiantes">Decanato de Estudiantes</option>
                    </select>
                </div>

                <div>
                    <label for="requested_role" class="block font-medium text-gray-700">Rol Solicitado</label>
                    <select name="requested_role" id="requested_role" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:outline-none">
                        <option value="">-- Selecciona un rol --</option>
                        <option value="Assignee">Assignee</option>
                        <option value="Contributor">Contributor</option>
                        <option value="Planner">Planner</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        @endif
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

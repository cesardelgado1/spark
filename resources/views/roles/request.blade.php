<x-layout>
    <x-slot:heading>
        Solicitar Acceso
    </x-slot:heading>

    <div class="px-6 py-4">
        @if(session('success'))
            <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('roles.request.submit') }}">
                @csrf

                {{-- Name (readonly from user) --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" readonly value="{{ auth()->user()->u_fname }} {{ auth()->user()->u_lname }}" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 bg-gray-100">
                </div>

                {{-- Department Select --}}
                <div class="mb-6">
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Decanato</label>
                    <select name="department" id="department" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
                        <option value="">-- Seleccionar --</option>
                        <option>Decanato de Administración</option>
                        <option>Decanato de Asuntos Académicos</option>
                        <option>Decanato de Estudiantes</option>
                        <option>Rectoría</option>
                        <option>Administración de Empresas</option>
                        <option>Artes y Ciencias</option>
                        <option>Ciencias Agrícolas</option>
                        <option>Ingeniería</option>
                    </select>
                </div>

                {{-- Requested Role Select --}}
                <div class="mb-6">
                    <label for="requested_role" class="block text-sm font-medium text-gray-700 mb-2">Rol Deseado</label>
                    <select name="requested_role" id="requested_role" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
                        <option value="">-- Seleccionar --</option>
                        <option value="Assignee">Asignado</option>
                        <option value="Contributor">Contribuidor </option>
                        <option value="Planner">Planner</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Auto-hide success message --}}
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

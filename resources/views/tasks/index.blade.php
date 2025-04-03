<x-layout>
    <x-slot:heading>
        Mis Tareas Asignadas
    </x-slot:heading>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-md" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="px-6 py-4 space-y-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <label for="sp_id">Filtrar por Plan Estratégico:</label>
            <select name="sp_id" id="sp_id" class="border rounded px-4 py-2">
                <option value="">-- Ver todos --</option>
                @foreach($strategicPlans as $plan)
                    <option value="{{ $plan->sp_id }}" {{ $planId == $plan->sp_id ? 'selected' : '' }}>
                        {{ $plan->sp_institution }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded">Filtrar</button>
        </form>

        @forelse($assignedObjectives as $assignment)
            <div class="p-4 border border-gray-300 rounded-lg bg-white shadow">
                <h2 class="text-lg font-bold text-gray-800">
                    Objetivo #{{ $assignment->objective->o_num }}:
                </h2>
                <p class="text-gray-700 mb-2">
                    {{ $assignment->objective->o_text }}
                </p>

                <div class="text-sm text-gray-600">
                    <p><strong>Meta:</strong> #{{ $assignment->objective->goal->g_num }}</p>
                    <p><strong>Asunto:</strong> #{{ $assignment->objective->goal->topic->t_num }}</p>
                    <p><strong>Asignado
                            por:</strong> {{ $assignment->assignedBy->u_fname }} {{ $assignment->assignedBy->u_lname }}
                    </p>
                    <p><strong>Fecha de asignación:</strong> {{ $assignment->created_at->format('d/m/Y') }}</p>
                    @role('Contributor')
                    <a href="{{ route('assignments.assignView', $assignment->ao_ObjToFill) }}"
                       class="inline-block mt-2 text-lg text-purple-600 hover:underline">
                        Asignar
                    </a>
                    @endrole
                </div>
            </div>
        @empty
            <p class="text-gray-600">No tienes tareas asignadas por el momento.</p>
        @endforelse
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.querySelector('[role="alert"]');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.remove();
                }, 4000);
            }
        });
    </script>

</x-layout>

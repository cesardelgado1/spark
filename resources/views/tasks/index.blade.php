{{--@php use Illuminate\Support\Facades\Auth; use App\Models\IndicatorValues; @endphp--}}
{{--<x-layout>--}}
{{--    <x-slot:heading>--}}
{{--        Mis Tareas Asignadas--}}
{{--    </x-slot:heading>--}}

{{--    @if(session('success'))--}}
{{--        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-md" role="alert">--}}
{{--            <strong class="font-bold">¡Éxito!</strong>--}}
{{--            <span class="block sm:inline">{{ session('success') }}</span>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="px-6 py-4 space-y-4">--}}
{{--        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">--}}
{{--            <label for="sp_id">Filtrar por Plan Estratégico:</label>--}}
{{--            <select name="sp_id" id="sp_id" class="border rounded px-4 py-2">--}}
{{--                <option value="">-- Ver todos --</option>--}}
{{--                @foreach($strategicPlans as $plan)--}}
{{--                    <option value="{{ $plan->sp_id }}" {{ $planId == $plan->sp_id ? 'selected' : '' }}>--}}
{{--                        {{ $plan->sp_institution }}: {{ $plan->sp_years }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <label for="fy" class="ml-4">Filtrar por Año Fiscal:</label>--}}
{{--            <select name="fy" id="fy" class="border rounded px-4 py-2">--}}
{{--                <option value="">-- Ver todos --</option>--}}
{{--                @foreach($availableFYs as $fyOption)--}}
{{--                    <option value="{{ $fyOption }}" {{ request('fy') === $fyOption ? 'selected' : '' }}>--}}
{{--                        {{ $fyOption }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Filtrar</button>--}}
{{--        </form>--}}

{{--        @forelse($assignedObjectives as $assignment)--}}
{{--            <div class="p-4 border border-gray-300 rounded-lg bg-white shadow">--}}

{{-- Cesar's Version ---------------------------------------------------------------------------------------}}
{{--                @php--}}
{{--                    $userId = Auth::id();--}}
{{--                    $year = date('Y');--}}
{{--                    $month = date('n');--}}
{{--                    $fy = ($month >= 7) ? "$year-" . ($year + 1) : ($year - 1) . "-$year";--}}

{{--                    $indicators = $assignment->objective->indicators->where('i_FY', $fy);--}}

{{--                    $filled = $indicators->every(function($indicator) use ($userId) {--}}
{{--                        return IndicatorValues::where('iv_u_id', $userId)--}}
{{--                                ->where('iv_ind_id', $indicator->i_id)--}}
{{--                                ->whereNotNull('iv_value')--}}
{{--                                ->where('iv_value', '!=', '')--}}
{{--                                ->exists();--}}
{{--                    });--}}
{{--                @endphp--}}
{{-- Mari's Version ---------------------------------------------------------------------------------------}}
{{--                @php--}}
{{--                    $userId = Auth::id();--}}
{{--                    $year = date('Y');--}}
{{--                    $month = date('n');--}}
{{--//                    $fy = ($month >= 7) ? "$year-" . ($year + 1) : ($year - 1) . "-$year";--}}
{{--//                    $fy = $fy ?? 'DEFAULT'; // fallback just in case, but `$fy` is passed from the controller--}}
{{--                    $fy = $fy ?? null;--}}

{{--                    $indicators = $assignment->objective->indicators;--}}
{{--                    if ($fy) {--}}
{{--                        $indicators = $indicators->where('i_FY', $fy);--}}
{{--                    }--}}

{{--                    $indicators = $assignment->objective->indicators->where('i_FY', $fy);--}}

{{--                    if (Auth::user()->u_type === 'Contributor') {--}}
{{--                        $assignees = $assignment->objective->assignedUsers--}}
{{--                            ->filter(fn($user) => $user->u_type === 'Assignee')--}}
{{--                            ->unique('id');--}}

{{--                        // If there are no indicators or no assignees, it's incomplete--}}
{{--                        if ($indicators->isEmpty() || $assignees->isEmpty()) {--}}
{{--                            $filled = false;--}}
{{--                        } else {--}}
{{--                            $filled = $assignees->every(function($assignee) use ($indicators) {--}}
{{--                                return $indicators->every(function($indicator) use ($assignee) {--}}
{{--                                    return \App\Models\IndicatorValues::where('iv_u_id', $assignee->id)--}}
{{--                                        ->where('iv_ind_id', $indicator->i_id)--}}
{{--                                        ->whereNotNull('iv_value')--}}
{{--                                        ->where('iv_value', '!=', '')--}}
{{--                                        ->exists();--}}
{{--                                });--}}
{{--                            });--}}
{{--                        }--}}
{{--                    } else {--}}
{{--                        if ($indicators->isEmpty()) {--}}
{{--                            $filled = false;--}}
{{--                        } else {--}}
{{--                            $filled = $indicators->every(function($indicator) use ($userId) {--}}
{{--                                return \App\Models\IndicatorValues::where('iv_u_id', $userId)--}}
{{--                                    ->where('iv_ind_id', $indicator->i_id)--}}
{{--                                    ->whereNotNull('iv_value')--}}
{{--                                    ->where('iv_value', '!=', '')--}}
{{--                                    ->exists();--}}
{{--                            });--}}
{{--                        }--}}
{{--                    }--}}
{{--                @endphp--}}

{{-- 1era Version ---------------------------------------------------------------------------------------------}}
{{--                @php--}}
{{--                    $userId = Auth::id();--}}
{{--                    $year = date('Y');--}}
{{--                    $month = date('n');--}}
{{--//                    $fy = ($month >= 7) ? "$year-" . ($year + 1) : ($year - 1) . "-$year";--}}
{{--                    $fy = $fy ?? 'DEFAULT'; // fallback just in case, but `$fy` is passed from the controller--}}

{{--                    $indicators = $assignment->objective->indicators->where('i_FY', $fy);--}}

{{--                    if (Auth::user()->u_type === 'Contributor') {--}}
{{--                        $assignees = $assignment->objective->assignedUsers--}}
{{--                            ->filter(fn($user) => $user->u_type === 'Assignee')--}}
{{--                            ->unique('id');--}}

{{--                        $filled = $assignees->every(function($assignee) use ($indicators) {--}}
{{--                            return $indicators->every(function($indicator) use ($assignee) {--}}
{{--                                return IndicatorValues::where('iv_u_id', $assignee->id)--}}
{{--                                    ->where('iv_ind_id', $indicator->i_id)--}}
{{--                                    ->whereNotNull('iv_value')--}}
{{--                                    ->where('iv_value', '!=', '')--}}
{{--                                    ->exists();--}}
{{--                            });--}}
{{--                        });--}}
{{--                    } else {--}}
{{--                        // para Assignee--}}
{{--                        $filled = $indicators->every(function($indicator) use ($userId) {--}}
{{--                            return IndicatorValues::where('iv_u_id', $userId)--}}
{{--                                ->where('iv_ind_id', $indicator->i_id)--}}
{{--                                ->whereNotNull('iv_value')--}}
{{--                                ->where('iv_value', '!=', '')--}}
{{--                                ->exists();--}}
{{--                        });--}}
{{--                    }--}}
{{--                @endphp--}}


{{--                <div class="mt-2 text-sm font-semibold">--}}
{{--                    Estado:--}}
{{--                    <span class="{{ $filled ? 'text-green-600' : 'text-red-600' }}">--}}
{{--                        {{ $filled ? 'Completado' : 'Incompleto' }}--}}
{{--                    </span>--}}
{{--                </div>--}}

{{--                <h2 class="text-lg font-bold text-gray-800">--}}
{{--                    Objetivo #{{ $assignment->objective->o_num }}:--}}
{{--                </h2>--}}
{{--                <p class="text-gray-700 mb-2">--}}
{{--                    {{ $assignment->objective->o_text }}--}}
{{--                </p>--}}

{{--                <div class="text-sm text-gray-600">--}}
{{--                    <p><strong>Meta:</strong> #{{ $assignment->objective->goal->g_num }}</p>--}}
{{--                    <p><strong>Asunto:</strong> #{{ $assignment->objective->goal->topic->t_num }}</p>--}}
{{--                    <p><strong>Plan:</strong> {{ $assignment->objective->goal->topic->strategicplan->sp_institution }} - {{ $assignment->objective->goal->topic->strategicplan->sp_years }}</p>--}}
{{--                    @php--}}
{{--                        $fyValue = $assignment->objective->indicators->where('i_FY', $fy)->first()->i_FY ?? 'N/A';--}}
{{--                    @endphp--}}
{{--                    <p><strong>Año Fiscal:</strong> {{ $fyValue }}</p>--}}
{{--                    <p><strong>Asignado por:</strong> {{ $assignment->assignedBy->u_fname }} {{ $assignment->assignedBy->u_lname }}</p>--}}
{{--                    <p><strong>Fecha de asignación:</strong> {{ $assignment->created_at->format('d/m/Y') }}</p>--}}

{{--                    @role('Contributor')--}}
{{--                    <a href="{{ route('roles.assignView', $assignment->ao_ObjToFill) }}"--}}
{{--                       class="inline-block mt-2 text-lg text-purple-600 hover:underline">--}}
{{--                        Asignar--}}
{{--                    </a>--}}
{{--                    @endrole--}}
{{--                    @role('Assignee')--}}
{{--                    <a href="{{ route('indicators.fill', $assignment->ao_ObjToFill) }}"--}}
{{--                       class="inline-block mt-2 text-sm text-indigo-600 hover:underline">--}}
{{--                        Llenar Indicadores--}}
{{--                    </a>--}}
{{--                    @endrole--}}
{{--                </div>--}}

{{--                @role('Contributor')--}}
{{--                @if($assignment->objective->assignedUsers->count())--}}
{{--                    <div class="mt-4 text-sm text-gray-700">--}}
{{--                        <strong>Estado de los asignados:</strong>--}}
{{--                        <ul class="ml-4 list-disc">--}}
{{--                            @foreach($assignment->objective->assignedUsers->filter(fn($user) => $user->u_type === 'Assignee')->unique('id') as $assignee)--}}
{{--                                @php--}}
{{--                                    $completed = $assignment->objective->indicators--}}
{{--                                        ->where('i_FY', $fy)--}}
{{--                                        ->every(function ($indicator) use ($assignee) {--}}
{{--                                            return IndicatorValues::where('iv_ind_id', $indicator->i_id)--}}
{{--                                                ->where('iv_u_id', $assignee->id)--}}
{{--                                                ->whereNotNull('iv_value')--}}
{{--                                                ->where('iv_value', '!=', '')--}}
{{--                                                ->exists();--}}
{{--                                        });--}}
{{--                                @endphp--}}
{{--                                <li>--}}
{{--                                    {{ $assignee->u_fname }} {{ $assignee->u_lname }} –--}}
{{--                                    <span class="{{ $completed ? 'text-green-600' : 'text-red-600' }}">--}}
{{--                                        {{ $completed ? 'Completo' : 'Incompleto' }}--}}
{{--                                    </span>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @endrole--}}

{{--            </div>--}}
{{--        @empty--}}
{{--            <p class="text-gray-600">No tienes tareas asignadas por el momento.</p>--}}
{{--        @endforelse--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const successMessage = document.querySelector('[role="alert"]');--}}
{{--            if (successMessage) {--}}
{{--                setTimeout(() => {--}}
{{--                    successMessage.remove();--}}
{{--                }, 4000);--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--</x-layout>--}}

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\IndicatorValues;
@endphp

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
                        {{ $plan->sp_institution }}: {{ $plan->sp_years }}
                    </option>
                @endforeach
            </select>

            <label for="fy" class="ml-4">Filtrar por Año Fiscal:</label>
            <select name="fy" id="fy" class="border rounded px-4 py-2">
                <option value="">-- Ver todos --</option>
                @foreach($availableFYs as $fyOption)
                    <option value="{{ $fyOption }}" {{ request('fy') === $fyOption ? 'selected' : '' }}>
                        {{ $fyOption }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Filtrar</button>
        </form>

        @forelse($assignedObjectives as $assignment)
            <div class="p-4 border border-gray-300 rounded-lg bg-white shadow">
                @php
                    $userId = Auth::id();
                    $indicators = $assignment->objective->indicators;
                    $indicators = $fy ? $indicators->where('i_FY', $fy) : $indicators;
                    $fyValue = $fy ?? 'Todos';

                    if (Auth::user()->u_type === 'Contributor') {
                        $assignees = $assignment->objective->assignedUsers
                            ->filter(fn($user) => $user->u_type === 'Assignee')
                            ->unique('id');

                        if ($indicators->isEmpty() || $assignees->isEmpty()) {
                            $filled = false;
                        } else {
                            $filled = $assignees->every(function($assignee) use ($indicators) {
                                return $indicators->every(function($indicator) use ($assignee) {
                                    return IndicatorValues::where('iv_u_id', $assignee->id)
                                        ->where('iv_ind_id', $indicator->i_id)
                                        ->whereNotNull('iv_value')
                                        ->where('iv_value', '!=', '')
                                        ->exists();
                                });
                            });
                        }
                    } else {
                        if ($indicators->isEmpty()) {
                            $filled = false;
                        } else {
                            $filled = $indicators->every(function($indicator) use ($userId) {
                                return IndicatorValues::where('iv_u_id', $userId)
                                    ->where('iv_ind_id', $indicator->i_id)
                                    ->whereNotNull('iv_value')
                                    ->where('iv_value', '!=', '')
                                    ->exists();
                            });
                        }
                    }
                @endphp

                <div class="mt-2 text-sm font-semibold">
                    Estado:
                    <span class="{{ $filled ? 'text-green-600' : 'text-red-600' }}">
                        {{ $filled ? 'Completado' : 'Incompleto' }}
                    </span>
                </div>

                <h2 class="text-lg font-bold text-gray-800">
                    Objetivo #{{ $assignment->objective->o_num }}:
                </h2>
                <p class="text-gray-700 mb-2">
                    {{ $assignment->objective->o_text }}
                </p>

                <div class="text-sm text-gray-600">
                    <p><strong>Meta:</strong> #{{ $assignment->objective->goal->g_num }}</p>
                    <p><strong>Asunto:</strong> #{{ $assignment->objective->goal->topic->t_num }}</p>
                    <p><strong>Plan:</strong> {{ $assignment->objective->goal->topic->strategicplan->sp_institution }} - {{ $assignment->objective->goal->topic->strategicplan->sp_years }}</p>
                    @php
                        $fyValue = $assignment->objective->indicators->first()->i_FY ?? 'N/A';
                    @endphp
                    <p><strong>Año Fiscal:</strong> {{ $fyValue }}</p>
                    <p><strong>Asignado por:</strong> {{ $assignment->assignedBy->u_fname }} {{ $assignment->assignedBy->u_lname }}</p>
                    <p><strong>Fecha de asignación:</strong> {{ $assignment->created_at->format('d/m/Y') }}</p>

                    @role('Contributor')
                    <a href="{{ route('roles.assignView', $assignment->ao_ObjToFill) }}"
                       class="inline-block mt-2 text-lg text-purple-600 hover:underline">
                        Asignar
                    </a>
                    @endrole

                    @role('Assignee')
                    <a href="{{ route('indicators.fill', $assignment->ao_ObjToFill) }}"
                       class="inline-block mt-2 text-sm text-indigo-600 hover:underline">
                        Llenar Indicadores
                    </a>
                    @endrole
                </div>

                @role('Contributor')
                @if($assignment->objective->assignedUsers->count())
                    <div class="mt-4 text-sm text-gray-700">
                        <strong>Estado de los asignados:</strong>
                        <ul class="ml-4 list-disc">
                            @foreach($assignment->objective->assignedUsers->filter(fn($user) => $user->u_type === 'Assignee')->unique('id') as $assignee)
                                @php
                                    $userIndicators = $assignment->objective->indicators;
                                    $userIndicators = $fy ? $userIndicators->where('i_FY', $fy) : $userIndicators;

                                    $completed = $userIndicators->every(function ($indicator) use ($assignee) {
                                        return IndicatorValues::where('iv_ind_id', $indicator->i_id)
                                            ->where('iv_u_id', $assignee->id)
                                            ->whereNotNull('iv_value')
                                            ->where('iv_value', '!=', '')
                                            ->exists();
                                    });
                                @endphp
                                <li>
                                    {{ $assignee->u_fname }} {{ $assignee->u_lname }} –
                                    <span class="{{ $completed ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $completed ? 'Completo' : 'Incompleto' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @endrole
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


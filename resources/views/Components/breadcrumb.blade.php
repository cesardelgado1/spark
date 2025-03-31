<nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-white" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
{{--        --}}{{-- Plan Estratégico --}}
{{--        <li class="inline-flex items-center">--}}
{{--            <a href="{{ route('strategicplans.topics', ['strategicplan' => $strategicplan->sp_id]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">--}}
{{--                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M9 21V9h6v12" />--}}
{{--                </svg>--}}
{{--                {{ $strategicplan->sp_institution }}--}}
{{--            </a>--}}
{{--        </li>--}}

        {{-- Asunto --}}
        @if(isset($topic))
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('topics.goals', ['topic' => $topic->t_id]) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        Asunto #{{ $topic->t_num }}
                    </a>
                </div>
            </li>
        @endif

        {{-- Meta --}}
        @if(isset($goal))
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('goals.objectives', ['goal' => $goal->g_id]) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        Meta #{{ $goal->g_num }}
                    </a>
                </div>
            </li>
        @endif

        {{-- Objetivo --}}
        @if(isset($objective))
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500">
                        Objetivo #{{ $objective->o_num }}
                    </span>
                </div>
            </li>
        @endif
    </ol>
</nav>

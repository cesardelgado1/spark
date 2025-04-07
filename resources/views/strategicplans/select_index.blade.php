<x-layout>
    <x-slot:heading>
        Planes Estratégicos
    </x-slot:heading>

    <div class="flex space-x-20 items-center mt-10">
        <!-- UPR logo and link -->
        <div class="flex flex-col items-center space-y-2">
            <img src="{{ asset('images/sello-upr.png') }}" alt="Plan Estratégico UPR">
            <a href="{{ route('strategicplans.index', ['institution' => 'UPR']) }}"
               class="bg-[#1F2937] text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                Plan Estratégico UPR
            </a>
        </div>

        <!-- UPRM logo and link -->
        <div class="flex flex-col items-center space-y-2">
            <img src="{{ asset('images/sello-uprm.png') }}" alt="Plan Estratégico UPRM" class="w-[350px]">
            <a href="{{ route('strategicplans.index', ['institution' => 'UPRM']) }}"
               class="bg-[#1F2937] text-white px-3 py-2 rounded-lg hover:bg-green-700 transition">
                Plan Estratégico UPRM
            </a>
        </div>
    </div>
</x-layout>

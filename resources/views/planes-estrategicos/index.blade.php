<x-layout>
    <x-slot:heading>
        Planes Estratégicos
    </x-slot:heading>

    <div class="flex space-x-20 items-center mt-10">
        <!-- UPR logo and link -->
        <div class="flex flex-col items-center space-y-2">
            <img src="{{ asset('images/sello-upr.png') }}">
            <a href="#" class="bg-[#1F2937] text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                Plan Estratégico UPR
            </a>
        </div>

        <!-- UPRM logo and link -->
        <div class="flex flex-col items-center space-y-2">
            <img src="{{ asset('images/sello-uprm.png') }}" alt="Plan Estratégico UPRM" class="w-[350px]">
            <x-button href="/strategicplans" class="hover:bg-green-700 transition">
                Plan Estratégico UPRM
            </x-button>
        </div>
    </div>


</x-layout>

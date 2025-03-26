<x-layout>
    <x-slot:heading>
        Planes Estratégicos
    </x-slot:heading>

    <div class="px-6 py-8">
        <div class="flex flex-col items-center space-y-6">
            <div class="flex space-x-4 justify-center">
                <img src="{{ asset('images/sello-upr.png') }}" class="w-[390px]">
                <img src="{{ asset('images/sello-uprm.png') }}" alt="Plan Estratégico UPRM" class="w-[250px]">
            </div>

            {{-- Botones --}}
            <div class="flex space-x-20">
                <a href="#" class="bg-[#1F2937] text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition">
                    Plan Estratégico UPR
                </a>

{{--                No se como mover solamente este boton hacia la derecha :( --}}
                <a href="#" class="bg-[#1F2937] text-white px-3 py-2 rounded-lg hover:bg-green-700 transition">
                    Plan Estratégico UPRM
                </a>
            </div>
        </div>
    </div>
</x-layout>

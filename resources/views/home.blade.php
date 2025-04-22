<x-layout>
    <x-slot:heading>
        Inicio
    </x-slot:heading>


    {{-- Page Content --}}
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            {{-- Left Section --}}
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Propósito:</h2>
                    <p class="text-gray-700">
                        Guiar el crecimiento, la eficiencia y el cumplimiento de la universidad con los estándares de acreditación.
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Objetivos:</h2>
                    <p class="text-gray-700">
                        Mejorar la calidad académica, la investigación, la eficiencia operativa y la sostenibilidad financiera.
                    </p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Asuntos Estratégicos:</h2>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        <li><strong>Innovación Académica</strong> – Modernizar los planes de estudio y los métodos de enseñanza.</li>
                        <li><strong>Eficiencia Institucional</strong> – Optimizar la administración y la asignación de recursos.</li>
                        <li><strong>Investigación e Impacto</strong> – Fortalecer los avances científicos y tecnológicos.</li>
                        <li><strong>Ética y Cultura</strong> – Promover la diversidad, la inclusión y la integridad institucional.</li>
                    </ol>

                </div>
            </div>

            {{-- Right Section: Chart --}}
            <div class="flex flex-col items-center justify-start text-center">
                <h3 class="text-md font-semibold text-gray-800 mb-4 leading-snug">
                    Progreso de Indicadores<br>
                    del Plan Estratégico de UPRM 2025-2030
                </h3>
                <div class="relative w-52 h-52">
                    <canvas id="circularProgress"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-gray-800">{{ $porcentaje }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('circularProgress').getContext('2d');
        const porcentaje = {{ $porcentaje }};
        const restante = 100 - porcentaje;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [porcentaje, restante],
                    backgroundColor: ['#3b82f6', '#e5e7eb'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '80%',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    </script>
</x-layout>

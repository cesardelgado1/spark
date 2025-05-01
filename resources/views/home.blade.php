<x-layout>
    <x-slot:heading>
        Inicio
    </x-slot:heading>

    {{-- Main content container --}}
    <div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

            {{-- Left section with purpose, objectives, and strategic issues --}}
            <div class="lg:col-span-2 space-y-4">
                <div>
                    {{-- Purpose section --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Propósito:</h2>
                    <p class="text-gray-700">
                        Guiar el crecimiento, la eficiencia y el cumplimiento de la universidad con los estándares de acreditación.
                    </p>
                </div>

                <div>
                    {{-- Objectives section --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Objetivos:</h2>
                    <p class="text-gray-700">
                        Mejorar la calidad académica, la investigación, la eficiencia operativa y la sostenibilidad financiera.
                    </p>
                </div>

                <div>
                    {{-- Strategic issues list --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Asuntos Estratégicos:</h2>
                    <ol class="list-decimal list-inside text-gray-700 space-y-2">
                        <li><strong>Innovación Académica</strong> – Modernizar los planes de estudio y los métodos de enseñanza.</li>
                        <li><strong>Eficiencia Institucional</strong> – Optimizar la administración y la asignación de recursos.</li>
                        <li><strong>Investigación e Impacto</strong> – Fortalecer los avances científicos y tecnológicos.</li>
                        <li><strong>Ética y Cultura</strong> – Promover la diversidad, la inclusión y la integridad institucional.</li>
                    </ol>
                </div>
            </div>

            {{-- Right section with the progress chart --}}
            <div class="flex flex-col items-center justify-start text-center">
                <h3 class="text-md font-semibold text-gray-800 mb-4 leading-snug">
                    Progreso de Indicadores<br>
                    del Plan Estratégico de UPRM {{ $latestPlan->sp_years }}
                </h3>

                {{-- Doughnut chart container --}}
                <div class="relative w-52 h-52">
                    <canvas id="circularProgress"></canvas>

                    {{-- Percentage value displayed in the center --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-gray-800">{{ $porcentaje }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Load Chart.js library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Get the canvas context
        const ctx = document.getElementById('circularProgress').getContext('2d');

        // Completed percentage
        const porcentaje = {{ $porcentaje }};
        // Remaining percentage
        const restante = 100 - porcentaje;

        // Initialize doughnut chart
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

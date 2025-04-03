<x-layout >
    <x-slot:heading>
        Inicio
    </x-slot:heading>

    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Plan Estratégico</h2>

        <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
            <div class="lg:w-2/3">
                <p class="text-lg font-semibold text-gray-800 mb-2">Propósito:</p>
                <p class="text-gray-700 mb-4">
                    Guiar el crecimiento, la eficiencia y el cumplimiento de la universidad con los estándares de acreditación.
                </p>

                <p class="text-lg font-semibold text-gray-800 mb-2">Objetivos:</p>
                <p class="text-gray-700 mb-4">
                    Mejorar la calidad académica, la investigación, la eficiencia operativa y la sostenibilidad financiera.
                </p>

                <p class="text-lg font-semibold text-gray-800 mb-2">Áreas Claves de Enfoque:</p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Innovación Académica</strong> – Modernizar los planes de estudio y los métodos de enseñanza.</li>
                    <li><strong>Efiencia Institucional</strong> – Optimizar la administración y la asignación de recursos.</li>
                    <li><strong>Investigación e Impacto</strong> – Fortalecer los avances científicos y tecnológicos.</li>
                    <li><strong>Ética y Cultura</strong> – Promover la diversidad, la inclusión y la integridad institucional.</li>
                </ul>
            </div>

            <div class="flex flex-col items-center justify-center lg:w-1/3 w-full">
                <h3 class="text-md font-semibold text-gray-800 mb-4 text-center">
                    Progreso de Indicadores<br>del Plan Estratégico de la UPRM 2025-2030
                </h3>
                <div class="relative w-52 h-52">
                    <canvas id="circularProgress"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-gray-800">{{ $porcentaje }}%</span>
                        <span class="text-xs text-gray-600 text-center leading-tight">
                    </span>
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

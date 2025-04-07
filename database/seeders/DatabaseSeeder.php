<?php

namespace Database\Seeders;

use App\Models\AssignObjectives;
use App\Models\StrategicPlan;
use App\Models\Topic;
use App\Models\Goal;
use App\Models\Objective;
use App\Models\Indicator;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy Users for UAT
        User::create([
            'u_fname' => 'Isidoro',
            'u_lname' => 'Couvertier Reyes',
            'email' => 'isidoro.couvertier@upr.edu',
            'password' => bcrypt('password'),
            'u_type' => 'Assignee',
        ]);
        User::create([
            'u_fname' => 'Cesar A',
            'u_lname' => 'Delgado Aponte',
            'email' => 'cesar.delgado2@upr.edu',
            'password' => bcrypt('password'),
            'u_type' => 'Contributor',
        ]);
        User::create([
            'u_fname' => 'Bienvenido',
            'u_lname' => 'Velez Rivera',
            'email' => 'bienvenido.velez@upr.edu',
            'password' => bcrypt('password'),
            'u_type' => 'Assignee',
        ]);

        User::create([
            'u_fname' => 'Agustin',
            'u_lname' => 'Rullan Toro',
            'email' => 'agustin.rullan@upr.edu',
            'password' => bcrypt('password'),
            'u_type' => 'Assignee',
        ]);

        User::create([
            'u_fname' => 'Nayda G',
            'u_lname' => 'Santiago Santiago',
            'email' => 'nayda.santiago@upr.edu',
            'password' => bcrypt('password'),
            'u_type' => 'Contributor',
        ]);

        // Strategic Plans
        $this->insertPlan('UPR', '2025-2030');
        $this->insertPlan('UPRM', '2025-2030');

        AssignObjectives::create([
            'ao_ObjToFill' => '1',
            'ao_assigned_to' => '2',
            'ao_assigned_by' => '1',
        ]);
    }

    private function insertPlan(string $institution, string $years)
    {
        $plan = StrategicPlan::create([
            'sp_institution' => $institution,
            'sp_years' => $years,
        ]);

        $topics = [
            [
                'number' => 1,
                'text' => 'Fortalecimiento de la calidad académica y pertinencia curricular',
                'goals' => [
                    [
                        'number' => 1,
                        'text' => 'Actualizar la oferta académica según las necesidades del mercado laboral.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Revisar el 100% de los programas académicos existentes.',
                                'indicators' => [
                                    ['number' => 1, 'text' => '% de programas académicos revisados.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Número de programas nuevos aprobados.','FY' => '2025-2026'],
                                    ['number' => 3, 'text' => '% de programas acreditados.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Incluir competencias transversales en todos los programas académicos.',
                                'indicators' => [
                                    ['number' => 1, 'text' => '% de programas que incluyen competencias transversales.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Talleres de capacitación ofrecidos a la facultad.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Número de estudiantes certificados en competencias clave.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Aumentar la oferta de cursos cortos y microcredenciales.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de microcredenciales ofrecidas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => '% de estudiantes matriculados en microcredenciales.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Encuestas de satisfacción de microcredenciales.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'number' => 2,
                        'text' => 'Incrementar la movilidad estudiantil internacional.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Firmar acuerdos de colaboración con universidades extranjeras.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de acuerdos firmados.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Número de estudiantes que participan en intercambios.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Número de facultativos visitantes.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Desarrollar programas de doble titulación.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de programas de doble titulación implementados.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => '% de participación estudiantil en doble titulación.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Número de egresados de programas de doble titulación.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Facilitar el acceso a becas de movilidad internacional.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de becas otorgadas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Fondos captados para movilidad internacional.','FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Número de estudiantes beneficiados.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'number' => 3,
                        'text' => 'Asegurar la pertinencia y calidad del currículo universitario.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Actualizar periódicamente el contenido de los programas.',
                                'indicators' => [
                                    ['number' => 1, 'text' => '% de programas actualizados en los últimos 5 años.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Número de docentes capacitados en actualización curricular.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Evaluaciones externas positivas de programas.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Promover la evaluación continua de la enseñanza y el aprendizaje.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de evaluaciones implementadas por programa.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Porcentaje de cursos evaluados anualmente.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Satisfacción estudiantil con los programas.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Integrar tecnología educativa en los planes de estudio.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de cursos con componentes tecnológicos.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Facultad capacitada en el uso de tecnología educativa.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Estudiantes certificados en competencias digitales.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'number' => 2,
                'text' => 'Innovación y transformación digital para la eficiencia institucional',
                'goals' => [
                    [
                        'number' => 1,
                        'text' => 'Implementar plataformas tecnológicas integradas.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Actualizar el sistema de gestión académica y administrativa.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de plataformas implementadas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Tiempos de respuesta administrativa mejorados.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Usuarios satisfechos con nuevas plataformas.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Aumentar la capacitación digital de la comunidad universitaria.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Talleres de capacitación ofrecidos.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => '% de personal capacitado digitalmente.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Número de certificaciones digitales obtenidas.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Optimizar el acceso a servicios digitales para estudiantes.',
                                'indicators' => [
                                    ['number' => 1, 'text' => '% de servicios estudiantiles accesibles en línea.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Encuestas de satisfacción digital.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Reducción en tiempos de atención estudiantil.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'number' => 2,
                        'text' => 'Promover el uso de datos para la toma de decisiones.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Desarrollar un sistema de inteligencia institucional.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Sistemas de reporte implementados.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Número de usuarios accediendo a reportes.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Decisiones basadas en datos documentadas.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Fortalecer la cultura de uso de datos.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Capacitaciones en análisis de datos.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Número de análisis anuales publicados.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Niveles de satisfacción del uso de datos.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Automatizar procesos administrativos clave.',
                                'indicators' => [
                                    ['number' => 1, 'text' => '% de procesos administrativos automatizados.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Reducción en errores administrativos.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Tiempos de procesamiento reducidos.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'number' => 3,
                'text' => 'Fomento de la investigación, creación y vinculación comunitaria',
                'goals' => [
                    [
                        'number' => 1,
                        'text' => 'Incrementar la producción científica de alto impacto.',
                        'objectives' => [
                            [
                                'number' => 1,
                                'text' => 'Aumentar la cantidad de publicaciones indexadas.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Publicaciones en revistas arbitradas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Colaboraciones internacionales.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Proyectos interdisciplinarios activos.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 2,
                                'text' => 'Fomentar la participación en convocatorias de investigación.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Número de propuestas sometidas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Fondos externos captados.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Nuevos proyectos financiados.', 'FY' => '2025-2026'],
                                ],
                            ],
                            [
                                'number' => 3,
                                'text' => 'Desarrollar programas de investigación en áreas estratégicas.',
                                'indicators' => [
                                    ['number' => 1, 'text' => 'Áreas estratégicas identificadas.', 'FY' => '2025-2026'],
                                    ['number' => 2, 'text' => 'Programas interdisciplinarios lanzados.', 'FY' => '2025-2026'],
                                    ['number' => 3, 'text' => 'Impacto de la investigación en la sociedad.', 'FY' => '2025-2026'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($topics as $topicData) {
            $topic = Topic::create([
                'sp_id' => $plan->sp_id,
                't_num' => $topicData['number'],
                't_text' => $topicData['text'],
            ]);

            foreach ($topicData['goals'] as $goalData) {
                $goal = Goal::create([
                    't_id' => $topic->t_id,
                    'g_num' => $goalData['number'],
                    'g_text' => $goalData['text'],
                ]);

                foreach ($goalData['objectives'] as $objectiveData) {
                    $objective = Objective::create([
                        'g_id' => $goal->g_id,
                        'o_num' => $objectiveData['number'],
                        'o_text' => $objectiveData['text'],
                    ]);

                    foreach ($objectiveData['indicators'] as $indicatorData) {
                        Indicator::create([
                            'o_id' => $objective->o_id,
                            'i_num' => $indicatorData['number'],
                            'i_text' => $indicatorData['text'],
                            'i_FY' => $indicatorData['FY'],
                        ]);
                    }
                }
            }
        }
    }
}

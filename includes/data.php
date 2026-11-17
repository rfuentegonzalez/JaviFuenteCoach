<?php
/**
 * Contenido de la web. Para actualizar el CV basta con editar este archivo:
 * no hace falta tocar el diseño.
 */

// Solo mes y año: la fecha exacta de nacimiento es privada y este repositorio es público.
// La edad cambia el 1 de julio (puede adelantarse unos días respecto al cumpleaños real).
$birth = new DateTimeImmutable('2009-07-01');
$age   = $birth->diff(new DateTimeImmutable('today'))->y;

return [
    'name'      => 'Javier Fuente',
    'full_name' => 'Javier Fuente Vallejo',
    'age'       => $age,
    'role'      => 'Entrenador de fútbol base',
    'current'   => 'Primer entrenador del Benjamín I (Preferente) en la Fundación Rayo Vallecano.',

    // Datos rápidos bajo la portada
    'facts' => [
        ['value' => 'UEFA C', 'label' => 'Licencia RFFM'],
        ['value' => '4',      'label' => 'temporadas en banquillo'],
        ['value' => '1',      'label' => 'ascenso a Preferente'],
        ['value' => $age,     'label' => 'años, y sigue jugando en Juvenil'],
    ],

    'about' => [
        "Tengo {$age} años, sigo jugando en categoría Juvenil y llevo cuatro temporadas en banquillos de fútbol base. Hace poco estaba en el lugar de mis jugadores, y eso me ayuda a conectar con ellos.",
        'Para mí el fútbol base es un sitio para aprender, disfrutar y crecer como persona. Busco que cada niño mejore, aprenda a tomar decisiones y sienta que forma parte de un equipo con identidad propia.',
    ],
    'quote' => 'El resultado no es lo más importante: quiero que cada niño mejore, aprenda a decidir y sienta que forma parte del equipo.',

    // Trayectoria, de la más reciente a la más antigua
    'seasons' => [
        [
            'season' => '2026/27',
            'now'    => true,
            'roles'  => [
                ['title' => 'Primer entrenador', 'club' => 'Fundación Rayo Vallecano', 'tags' => ['Benjamín I', 'Preferente']],
                ['title' => 'Aprendiz de analista', 'club' => 'Rayo Vallecano B', 'tags' => ['3.ª RFEF', 'Análisis de vídeo']],
            ],
        ],
        [
            'season' => '2025/26',
            'roles'  => [
                ['title' => 'Primer entrenador', 'club' => 'ED Moratalaz', 'tags' => ['Benjamín B', 'U10', 'Primera'],
                 'badge' => 'Ascenso a Preferente como mejor tercero'],
            ],
        ],
        [
            'season' => '2024/25',
            'roles'  => [
                ['title' => 'Segundo entrenador', 'club' => 'ED Moratalaz', 'tags' => ['Benjamín E', 'U9', 'Primera']],
            ],
        ],
        [
            'season' => '2023/24',
            'roles'  => [
                ['title' => 'Segundo entrenador', 'club' => 'ED Moratalaz', 'tags' => ['Prebenjamín B', 'U8', 'Preferente']],
            ],
        ],
    ],

    // Filosofía
    'ideas' => [
        ['title' => 'Identidad', 'text' => 'Celebramos cada acción y cada intento. Todos se sienten parte del grupo.'],
        ['title' => 'Aprender a decidir', 'text' => 'Planteo situaciones y preguntas para que sean ellos quienes encuentren las soluciones en el campo.'],
        ['title' => 'Refuerzo positivo', 'text' => 'Primero lo que han hecho bien; después, cómo hacerlo aún mejor.'],
    ],

    'questions' => [
        '¿Dónde está el compañero libre?',
        '¿Le doy línea de pase?',
        '¿Hay otra opción?',
        '¿Cómo ayudas a tu compañero?',
    ],


    'strengths' => [
        ['title' => 'Cercanía', 'text' => 'Por edad entiendo cómo piensan los jugadores y qué les motiva.'],
        ['title' => 'Comunicación positiva', 'text' => 'Corrijo desde el refuerzo, sin bajar la autoestima del grupo.'],
        ['title' => 'Enseño a pensar', 'text' => 'Jugadores más autónomos, creativos y responsables.'],
        ['title' => 'Ojo para el juego', 'text' => 'Detecto rápido lo que pasa en el campo y por qué.'],
        ['title' => 'Ganas de aprender', 'text' => 'Me dejo aconsejar y pregunto constantemente para mejorar.'],
    ],

    // Camino de licencias UEFA: done = conseguida, next = siguiente paso, later = más adelante
    'licenses' => [
        ['name' => 'C', 'status' => 'done', 'note' => 'Conseguida en mayo de 2026'],
        ['name' => 'B', 'status' => 'next', 'note' => 'Se matricula esta temporada'],
        ['name' => 'A', 'status' => 'later', 'note' => 'Más adelante'],
        ['name' => 'Pro', 'status' => 'later', 'note' => 'Más adelante'],
    ],

    // Otra formación en curso
    'education' => [
        ['title' => 'Ciclo Formativo de Grado Medio TECO', 'where' => 'TAFAD Madrid, Torrejón de Ardoz', 'when' => '2.º curso', 'status' => 'progress'],
        ['title' => 'Analista de fútbol', 'where' => 'Aprendiz en el Rayo Vallecano B y curso de analista', 'when' => 'Esta temporada', 'status' => 'progress'],
    ],
];

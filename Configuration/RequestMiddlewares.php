<?php

return [
    'backend' => [
        'konradmichalik/typo3-environment-indicator/favicon' => [
            'target' => \KonradMichalik\Typo3EnvironmentIndicator\Middleware\FaviconMiddleware::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
        ],
    ],
];

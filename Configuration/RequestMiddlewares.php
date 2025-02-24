<?php

return [
    'frontend' => [
        'konradmichalik/typo3-environment-indicator/frontend-favicon' => [
            'target' => \KonradMichalik\Typo3EnvironmentIndicator\Middleware\FrontendFaviconMiddleware::class,
            'before' => [
                'typo3/cms-core/response-propagation',
            ],
        ],
    ],
    'backend' => [
        'konradmichalik/typo3-environment-indicator/backend-favicon' => [
            'target' => \KonradMichalik\Typo3EnvironmentIndicator\Middleware\BackendFaviconMiddleware::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
        ],
    ],
];

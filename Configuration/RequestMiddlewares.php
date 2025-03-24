<?php

return [
    'frontend' => [
        'konradmichalik/typo3-environment-indicator/frontend-favicon' => [
            'target' => \KonradMichalik\Typo3EnvironmentIndicator\Middleware\FrontendFaviconMiddleware::class,
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
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
        'konradmichalik/typo3-environment-indicator/backend-logo' => [
            'target' => \KonradMichalik\Typo3EnvironmentIndicator\Middleware\BackendLogoMiddleware::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
        ],
    ],
];

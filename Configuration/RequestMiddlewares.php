<?php

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

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

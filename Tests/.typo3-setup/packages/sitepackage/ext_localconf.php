<?php

declare(strict_types=1);

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

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;
use KonradMichalik\Typo3EnvironmentIndicator\Enum;
use KonradMichalik\Typo3EnvironmentIndicator\Image;

defined('TYPO3') || die();

/**
* Context "Development/Text"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Text'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ]),
        ]),
        new Indicator\Backend\Logo([
            new Image\Modifier\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ]),
        ]),
        new Indicator\Frontend\Image([
            new Image\Modifier\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#f39c12',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#f39c12',
        ]),
        new Indicator\Backend\Topbar([
            'color' => '#f39c12',
            'removeTransition' => true,
        ]),
        new Indicator\Backend\Widget([
            'color' => '#f39c12',
        ]),
    ]
);

/**
* Context "Development/Triangle"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Triangle'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\TriangleModifier([
                'color' => '#283593',
                'position' => 'top right',
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#B39DDB',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#B39DDB',
        ]),
    ]
);

/**
* Context "Development/Circle"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Circle'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\CircleModifier([
                'color' => '#1B5E20',
                'position' => 'top left',
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#1B5E20',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#1B5E20',
        ]),
    ]
);

/**
* Context "Development/Frame"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Frame'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\FrameModifier([
                'color' => '#AA00FF',
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#AA00FF',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#AA00FF',
        ]),
    ]
);

/**
* Context "Development/Colorize"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Colorize'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\ColorizeModifier([
                'color' => '#039BE5',
            ]),
        ]),
        new Indicator\Favicon([
            new Image\Modifier\ColorizeModifier([
                'color' => '#EC407A',
                'opacity' => 0.5,
            ]),
        ], scope: Enum\Scope::Frontend),
        new Indicator\Frontend\Hint([
            'color' => '#039BE5',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#039BE5',
        ]),
    ]
);

/**
* Context "Development/Replace"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Replace'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\ReplaceModifier([
                'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#FFF176',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#FFF176',
        ]),
    ]
);

/**
* Context "Development/Overlay"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Overlay'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\OverlayModifier([
                'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#827717',
        ]),
        new Indicator\Backend\Toolbar([
            'color' => '#827717',
        ]),
    ]
);

/**
* Context "Development/FrontendHint"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/FrontendHint'),
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\Modifier\ColorizeModifier([
                'color' => '#FFF176',
                'brightness' => 100,
            ]),
        ]),
        new Indicator\Frontend\Hint([
            'color' => '#FFF176',
            'text' => 'Frontend',
            'position' => 'bottom right',
        ]),
    ]
);

/**
* Context "Development/BackendTopbar"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/BackendTopbar'),
    ],
    indicators: [
        new Indicator\Backend\Topbar([
            'color' => '#bd593a',
        ]),
    ]
);

/**
* Context "Development/Admin"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Admin'),
        new Trigger\Admin(),
    ],
    indicators: [
        new Indicator\Backend\Topbar([
            'color' => '#00ACC1',
        ]),
    ]
);

/**
* Context "Development/Custom"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Custom'),
        new Trigger\Custom(
            function () {
                return false;
            }
        ),
    ],
    indicators: [
        new Indicator\Backend\Topbar([
            'color' => '#00ACC1',
        ]),
    ]
);

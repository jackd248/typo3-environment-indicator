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

use KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ContextItem;
use KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\TopbarItem;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;
use KonradMichalik\Typo3EnvironmentIndicator\Image;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = ContextItem::class;
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392104] = TopbarItem::class;

// Default configuration
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] = [
    Image\Modifier\TextModifier::class => [
        'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
        'position' => 'top',
    ],
    Image\Modifier\TriangleModifier::class => [
        'size' => 0.7,
        'position' => 'bottom right',
    ],
    Image\Modifier\CircleModifier::class => [
        'size' => 0.4,
        'padding' => 0.1,
        'position' => 'bottom right',
    ],
    Image\Modifier\FrameModifier::class => [
        'borderSize' => 5,
    ],
    Image\Modifier\ColorizeModifier::class => [
        'opacity' => 1,
    ],
    Image\Modifier\OverlayModifier::class => [
        'size' => 0.5,
        'padding' => 0.1,
        'position' => 'bottom right',
    ],
    Indicator\Favicon::class => [
        '_path' => 'typo3temp/assets/favicons/',
    ],
    Indicator\Backend\Logo::class => [
        '_path' => 'typo3temp/assets/images/',
    ],
    Indicator\Frontend\Image::class => [
        '_path' => 'typo3temp/assets/images/',
    ],
    Indicator\Backend\Toolbar::class => [
        'icon' => [
            'context' => 'information-application-context',
        ],
        'index' => 0,
    ],
    Indicator\Frontend\Hint::class => [
        'position' => 'top left',
    ],
];

// Presets
if ($GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['general']['defaultConfiguration'] ?? false) {
    Configuration\Handler::addIndicator(
        triggers: [
            new Trigger\ApplicationContext('Development*'),
        ],
        indicators: [
            new Indicator\Favicon([
                new Image\Modifier\TextModifier([
                    'text' => 'DEV',
                    'color' => '#bd593a',
                    'stroke' => [
                        'color' => '#ffffff',
                        'width' => 3,
                    ],
                ]),
            ]),
            new Indicator\Frontend\Hint([
                'color' => '#bd593a',
            ]),
            new Indicator\Backend\Toolbar([
                'color' => '#bd593a',
            ]),
        ]
    );

    Configuration\Handler::addIndicator(
        triggers: [
            new Trigger\ApplicationContext('Testing*'),
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
            new Indicator\Frontend\Hint([
                'color' => '#f39c12',
            ]),
            new Indicator\Backend\Toolbar([
                'color' => '#f39c12',
            ]),
        ]
    );

    Configuration\Handler::addIndicator(
        triggers: [
            new Trigger\ApplicationContext('Production/Staging', 'Production/Stage'),
        ],
        indicators: [
            new Indicator\Favicon([
                new Image\Modifier\TextModifier([
                    'text' => 'STG',
                    'color' => '#2f9c91',
                    'stroke' => [
                        'color' => '#ffffff',
                        'width' => 3,
                    ],
                ]),
            ]),
            new Indicator\Frontend\Hint([
                'color' => '#2f9c91',
            ]),
            new Indicator\Backend\Toolbar([
                'color' => '#2f9c91',
            ]),
        ]
    );

    Configuration\Handler::addIndicator(
        triggers: [
            new Trigger\ApplicationContext('Production/Standby'),
        ],
        indicators: [
            new Indicator\Backend\Toolbar([
                'color' => '#2f9c91',
            ]),
        ]
    );
}

<?php

declare(strict_types=1);

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;
use KonradMichalik\Typo3EnvironmentIndicator\Image;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ContextItem::class;
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392104] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\TopbarItem::class;

// Default configuration
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['current'] = [];
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['defaults'] = [
    Image\TextModifier::class => [
        'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
        'position' => 'top left',
    ],
    Image\TriangleModifier::class => [
        'size' => 0.7,
        'position' => 'bottom right',
    ],
    Image\CircleModifier::class => [
        'size' => 0.4,
        'padding' => 0.1,
        'position' => 'bottom right',
    ],
    Image\FrameModifier::class => [
        'borderSize' => 5,
    ],
    Image\ColorizeModifier::class => [
        'opacity' => 1,
    ],
    Image\OverlayModifier::class => [
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
                new Image\TextModifier([
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
                new Image\TextModifier([
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
                new Image\TextModifier([
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

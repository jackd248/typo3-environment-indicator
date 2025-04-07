<?php

declare(strict_types=1);

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;
use KonradMichalik\Typo3EnvironmentIndicator\Image;

defined('TYPO3') || die();

/**
* Context "Development/Text"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Text')
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
            ])
        ]),
        new Indicator\Backend\Logo([
            new Image\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ])
        ]),
        new Indicator\Frontend\Image([
            new Image\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ])
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
        ])
    ]
);

/**
* Context "Development/Triangle"
*/
Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Development/Triangle')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\TriangleModifier([
                'color' => '#283593',
                'position' => 'top right'
            ])
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
        new Trigger\ApplicationContext('Development/Circle')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\CircleModifier([
                'color' => '#1B5E20',
                'position' => 'top left'
            ])
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
        new Trigger\ApplicationContext('Development/Frame')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\FrameModifier([
                'color' => '#AA00FF',
            ])
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
        new Trigger\ApplicationContext('Development/Colorize')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\ColorizeModifier([
                'color' => '#039BE5',
            ]) // @ToDo: Make Frontend Favicon Modifier Opacity 0.5
        ]),
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
        new Trigger\ApplicationContext('Development/Replace')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\ReplaceModifier([
                'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
            ])
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
        new Trigger\ApplicationContext('Development/Overlay')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\OverlayModifier([
                'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
            ])
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
        new Trigger\ApplicationContext('Development/FrontendHint')
    ],
    indicators: [
        new Indicator\Favicon([
            new Image\ColorizeModifier([
                'color' => '#FFF176',
                'brightness' => 100,
            ])
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
        new Trigger\ApplicationContext('Development/BackendTopbar')
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
        new Trigger\Admin()
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
        )
    ],
    indicators: [
        new Indicator\Backend\Topbar([
            'color' => '#00ACC1',
        ]),
    ]
);

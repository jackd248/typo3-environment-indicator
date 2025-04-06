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
        new Trigger\ApplicationContext('Development/*', 'Testing')
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

//\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
//    applicationContext: 'Development/Text',
//    faviconModifierConfiguration: [
//        \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class =>
//        [
//            'text' => 'TEXT',
//            'color' => '#283593',
//            'stroke' => [
//                'color' => '#ffffff',
//                'width' => 3,
//            ],
//            'position' => 'top',
//        ]
//    ],
//    backendLogoModifierConfiguration: [
//        \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class =>
//        [
//            'text' => 'TEXT',
//            'color' => '#283593',
//            'stroke' => [
//                'color' => '#ffffff',
//                'width' => 3,
//            ],
//        ]
//    ],
//    frontendImageModifierConfiguration: [
//        \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class =>
//            [
//                'text' => 'TEXT',
//                'color' => '#283593',
//                'stroke' => [
//                    'color' => '#ffffff',
//                    'width' => 3,
//                ],
//            ]
//    ],
//    frontendHintConfiguration: [
//        'color' => '#283593',
//    ],
//    backendToolbarConfiguration: [
//        'color' => '#283593',
//    ],
//);

/**
* Context "Development/Triangle"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Triangle',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class =>
        [
            'color' => '#283593',
            'position' => 'top right'
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#B39DDB',
    ],
    backendToolbarConfiguration: [
        'color' => '#B39DDB',
    ]
);

/**
* Context "Development/Circle"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Circle',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\CircleModifier::class =>
        [
            'color' => '#1B5E20',
            'position' => 'top left'
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#1B5E20',
    ],
    backendToolbarConfiguration: [
        'color' => '#1B5E20',
    ]
);

/**
* Context "Development/Frame"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Frame',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\FrameModifier::class =>
        [
            'color' => '#AA00FF',
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#AA00FF',
    ],
    backendToolbarConfiguration: [
        'color' => '#AA00FF',
    ]
);

/**
* Context "Development/Colorize"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Colorize',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class =>
        [
            'color' => '#039BE5',
        ]
    ],
    faviconModifierFrontendConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class =>
        [
            'opacity' => 0.5
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#039BE5',
    ],
    backendToolbarConfiguration: [
        'color' => '#039BE5',
    ]
);

/**
* Context "Development/Replace"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Replace',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\ReplaceModifier::class =>
        [
            'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#FFF176',
    ],
    backendToolbarConfiguration: [
        'color' => '#FFF176',
    ]
);

/**
* Context "Development/Overlay"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/Overlay',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\OverlayModifier::class =>
        [
            'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#827717',
    ],
    backendToolbarConfiguration: [
        'color' => '#827717',
    ],
    backendTopbarConfiguration: [
        'color' => '#827717',
    ]
);

/**
* Context "Development/FrontendHint"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/FrontendHint',
    faviconModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class =>
        [
            'color' => '#FFF176',
            'brightness' => 100,
        ]
    ],
    frontendHintConfiguration: [
        'color' => '#FFF176',
        'text' => 'Frontend',
        'position' => 'bottom right',
    ],
    backendToolbarConfiguration: null
);

/**
* Context "Development/BackendTopbar"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/BackendTopbar',
    backendToolbarConfiguration: null,
    backendTopbarConfiguration: [
        'color' => '#bd593a',
    ]
);

/**
* Context "Development/GlobalImage"
*/
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
    applicationContext: 'Development/GlobalImage',
    globalImageModifierConfiguration: [
        \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class =>
            [
                'text' => 'ALL',
                'color' => '#283593',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ]
    ],
);

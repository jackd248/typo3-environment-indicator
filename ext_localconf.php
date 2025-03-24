<?php

declare(strict_types=1);

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ContextItem::class;
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392104] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\TopbarItem::class;

// Preset configuration
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY] = [
    'context' => [
        'Production' => [
            'backendToolbar' => [
                'color' => 'transparent',
            ],
        ],
        'Production/Standby' => [
            'backendToolbar' => [
                'color' => '#2f9c91',
            ],
        ],
        'Production/Staging' => [
            'frontendHint' => [
                'color' => '#f39c12',
            ],
            'backendToolbar' => [
                'color' => '#f39c12',
            ],
            'favicon' => [
                '*' => [
                    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                        'text' => 'STAGE',
                        'color' => '#f39c12',
                        'stroke' => [
                            'color' => '#ffffff',
                            'width' => 3,
                        ],
                    ],
                ],
            ],
        ],
        'Testing' => [
            'frontendHint' => [
                'color' => '#f39c12',
            ],
            'backendToolbar' => [
                'color' => '#f39c12',
            ],
            'favicon' => [
                '*' => [
                    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                        'text' => 'TEST',
                        'color' => '#f39c12',
                        'stroke' => [
                            'color' => '#ffffff',
                            'width' => 3,
                        ],
                    ],
                ],
            ],
        ],
        'Development' => [
            'frontendHint' => [
                'color' => '#bd593a',
            ],
            'backendToolbar' => [
                'color' => '#bd593a',
            ],
            'favicon' => [
                '*' => [
                    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                        'text' => 'DEV',
                        'color' => '#bd593a',
                        'stroke' => [
                            'color' => '#ffffff',
                            'width' => 3,
                        ],
                    ],
                ],
            ],
        ],
    ],
    'global' => [
        'frontendHint' => [
            'position' => 'top left',
        ],
        'backendToolbar' => [
            'icon' => [
                'context' => 'information-application-context',
            ],
            'index' => 0,
        ],
        'favicon' => [
            'path' => 'typo3temp/assets/favicons/',
            'defaults' => [
                \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                    'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
                    'position' => 'top left',
                ],
                \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class => [
                    'size' => 0.7,
                    'position' => 'bottom right',
                ],
                \KonradMichalik\Typo3EnvironmentIndicator\Image\CircleModifier::class => [
                    'size' => 0.4,
                    'padding' => 0.1,
                    'position' => 'bottom right',
                ],
                \KonradMichalik\Typo3EnvironmentIndicator\Image\FrameModifier::class => [
                    'borderSize' => 5,
                ],
                \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class => [
                    'opacity' => 1,
                ],
                \KonradMichalik\Typo3EnvironmentIndicator\Image\OverlayModifier::class => [
                    'size' => 0.5,
                    'padding' => 0.1,
                    'position' => 'bottom right',
                ],
            ],
        ],
    ],
];

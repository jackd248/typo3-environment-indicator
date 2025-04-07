<?php

declare(strict_types=1);

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ContextItem::class;
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392104] = \KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\TopbarItem::class;

// Preset configuration
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY] = [
    'current' => [],
    'context' => [
        'Production/Standby' => [
            'backend' => [
                'toolbar' => [
                    'color' => '#2f9c91',
                ],
            ],
        ],
        'Production/Staging' => [
            'frontend' => [
                'hint' => [
                    'color' => '#2f9c91',
                ],
            ],
            'backend' => [
                'toolbar' => [
                    'color' => '#2f9c91',
                ],
            ],
            'both' => [
                'favicon' => [
                    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                        'text' => 'STG',
                        'color' => '#2f9c91',
                        'stroke' => [
                            'color' => '#ffffff',
                            'width' => 3,
                        ],
                    ],
                ],
            ],
        ],
        'Testing' => [
            'frontend' => [
                'hint' => [
                    'color' => '#f39c12',
                ],
            ],
            'backend' => [
                'toolbar' => [
                    'color' => '#f39c12',
                ],
            ],
            'both' => [
                'favicon' => [
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
            'frontend' => [
                'hint' => [
                    'color' => '#bd593a',
                ],
            ],
            'backend' => [
                'toolbar' => [
                    'color' => '#bd593a',
                ],
            ],
            'both' => [
                'favicon' => [
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
        'frontend' => [
            'hint' => [
                'position' => 'top left',
            ],
        ],
        'backend' => [
            'toolbar' => [

                'icon' => [
                    'context' => 'information-application-context',
                ],
                'index' => 0,
            ],
        ],
        'both' => [
            'image' => [
                'path' => 'typo3temp/assets/images/',
            ],
            'logo' => [
                'path' => 'typo3temp/assets/images/',
            ],
            'favicon' => [
                'path' => 'typo3temp/assets/favicons/',
            ],
            'modifier' => [
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
    ],
];

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY]['defaults'] = [
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
    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Favicon::class => [
        '_path' => 'typo3temp/assets/favicons/',
    ],
    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Logo::class => [
        '_path' => 'typo3temp/assets/images/',
    ],
    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Image::class => [
        '_path' => 'typo3temp/assets/images/',
    ],
    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Toolbar::class => [
        'icon' => [
            'context' => 'information-application-context',
        ],
        'index' => 0,
    ],
    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Frontend\Hint::class => [
        'position' => 'top left',
    ],
];

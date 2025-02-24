<?php

declare(strict_types=1);

use KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ProjectStatusItem;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['ei'] = ['KonradMichalik\\Typo3EnvironmentIndicator\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = ProjectStatusItem::class;

// Preset configuration
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY] = [
    'context' => [
        'Production/Standby' => [
            'toolbar' => [
                'color' => '#2f9c91',
            ],
        ],
        'Production/Staging' => [
            'toolbar' => [
                'color' => '#f39c12',
            ],
            'favicon' => [
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
        'Testing' => [
            'toolbar' => [
                'color' => '#f39c12',
            ],
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
        'Development' => [
            'toolbar' => [
                'color' => '#bd593a',
            ],
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
    'global' => [
        'toolbar' => [
            'icon' => [
                'context' => 'information-application-context',
                'version' => 'actions-tag',
            ],
        ],
        'favicon' => [
            'path' => 'typo3temp/assets/favicons/',
            'defaults' => [
                \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                    'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
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
            ],
        ],
    ],
];

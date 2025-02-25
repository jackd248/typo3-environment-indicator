<?php

declare(strict_types=1);

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY]['context'] = array_merge($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY]['context'],[
    'Development/Text' => [
        'frontendHint' => [
            'color' => '#283593',
        ],
        'backendToolbar' => [
            'color' => '#283593',
        ],
        'favicon' => [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class => [
                'text' => 'TEXT',
                'color' => '#283593',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ],
        ],
    ],
    'Development/Triangle' => [
        'frontendHint' => [
            'color' => '#B39DDB',
        ],
        'backendToolbar' => [
            'color' => '#B39DDB',
        ],
        'favicon' => [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class => [
                'color' => '#B39DDB',
                'position' => 'top right'
            ],
        ],
    ],
    'Development/Circle' => [
        'frontendHint' => [
            'color' => '#1B5E20',
        ],
        'backendToolbar' => [
            'color' => '#1B5E20',
        ],
        'favicon' => [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\CircleModifier::class => [
                'color' => '#1B5E20',
                'position' => 'top left'
            ],
        ],
    ],
    'Development/Frame' => [
        'frontendHint' => [
            'color' => '#AA00FF',
        ],
        'backendToolbar' => [
            'color' => '#AA00FF',
        ],
        'favicon' => [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\FrameModifier::class => [
                'color' => '#AA00FF',
            ],
        ],
    ],
]);

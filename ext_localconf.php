<?php

declare(strict_types=1);

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][\KonradMichalik\Typo3EnvironmentIndicator\Configuration::EXT_KEY] = [
    'environment' => [
        'Production/Staging' => [
            'favicon' => [
                'type' => 'text',
                'text' => 'STAGE',
                'color' => '#F57C00',
                'stroke_color' => '#FFFFFF',
                'stroke_width' => '3',
            ],
        ],
        'Testing' => [
            'favicon' => [
                'type' => 'text',
                'text' => 'TEST',
                'color' => '#F57C00',
                'stroke_color' => '#FFFFFF',
                'stroke_width' => '3',
            ],
        ],
        'Development' => [
            'favicon' => [
                'type' => 'text',
                'text' => 'DEV',
                'color' => '#FF0000',
                'stroke_color' => '#FFFFFF',
                'stroke_width' => '3',
            ],
        ],
    ],
    'general' => [
        'favicon' => [
            'handler' => \KonradMichalik\Typo3EnvironmentIndicator\Service\FaviconHandler::class,
            'path' => 'typo3temp/assets/favicons/',
            'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
        ],
    ],
];

<?php

declare(strict_types=1);

use KonradMichalik\Typo3EnvironmentIndicator\Backend\ToolbarItems\ProjectStatusItem;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['ei'] = ['KonradMichalik\\Typo3EnvironmentIndicator\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1740392103] = ProjectStatusItem::class;

// Default configuration
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
                'type' => 'text',
                'text' => 'STAGE',
                'color' => '#f39c12',
                'stroke_color' => '#ffffff',
                'stroke_width' => '3',
            ],
        ],
        'Testing' => [
            'toolbar' => [
                'color' => '#f39c12',
            ],
            'favicon' => [
                'type' => 'text',
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke_color' => '#ffffff',
                'stroke_width' => '3',
            ],
        ],
        'Development' => [
            'toolbar' => [
                'color' => '#bd593a',
            ],
            'favicon' => [
                'type' => 'text',
                'text' => 'DEV',
                'color' => '#bd593a',
                'stroke_color' => '#ffffff',
                'stroke_width' => '3',
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
            'handler' => \KonradMichalik\Typo3EnvironmentIndicator\Service\FaviconHandler::class,
            'path' => 'typo3temp/assets/favicons/',
            'font' => 'EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf',
        ],
    ],
];

<?php

declare(strict_types=1);


defined('TYPO3') || die();

/**
 * Context "Development/Text"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Text',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class,
    [
            'text' => 'TEXT',
            'stroke' => [
                'color' => '#ffffff',
                'width' => 3,
            ],
            'position' => 'top',
        ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Text',
    '#283593'
);

/**
 * Context "Development/Triangle"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Triangle',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class,
    [
        'position' => 'top right'
    ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Triangle',
    '#B39DDB'
);

/**
 * Context "Development/Circle"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Circle',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\CircleModifier::class,
    [
        'position' => 'top left'
    ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Circle',
    '#1B5E20'
);

/**
 * Context "Development/Frame"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Frame',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\FrameModifier::class
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Frame',
    '#AA00FF'
);

/**
 * Context "Development/Colorize"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Colorize',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Colorize',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class,
    [
        'opacity' => 0.5
    ],
    'frontend'
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Colorize',
    '#039BE5'
);

/**
 * Context "Development/Replace"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Replace',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ReplaceModifier::class,
    [
        'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
    ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/Replace',
    '#FFF176'
);

/**
 * Context "Development/FrontendHint"
 */
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/FrontendHint',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFrontendHintConfigurationByContext(
    'Development/FrontendHint',
    [
        'text' => 'Frontend',
        'position' => 'bottom right',
    ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development/FrontendHint',
    '#FFF176'
);

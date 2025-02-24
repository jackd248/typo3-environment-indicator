<?php

declare(strict_types=1);

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('Access denied.');

ExtensionManagementUtility::addStaticFile(
    Configuration::EXT_KEY,
    'Configuration/TypoScript',
    'Environment Indicator'
);

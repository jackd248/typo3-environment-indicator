<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Utility;

use Exception;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration;

use function sprintf;

/**
 * ConfigurationUtility.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
class ConfigurationUtility
{
    public static function configByContext(
        string $applicationContext,
        ?array $frontendHintConfiguration = [],
        ?array $backendToolbarConfiguration = [],
        ?array $backendTopbarConfiguration = [],
        ?array $faviconModifierConfiguration = [],
        ?array $faviconModifierFrontendConfiguration = [],
        ?array $faviconModifierBackendConfiguration = [],
        ?array $frontendImageModifierConfiguration = [],
        ?array $backendLogoModifierConfiguration = [],
        ?array $globalImageModifierConfiguration = [],
    ): void {
        throw new Exception(sprintf('The "%s" method is deprecated and no longer support. Use the "%s" method instead. See the documentation for the correct usage.', __METHOD__, Configuration\Handler::class.'::addIndicator'), 5404480452);
    }
}

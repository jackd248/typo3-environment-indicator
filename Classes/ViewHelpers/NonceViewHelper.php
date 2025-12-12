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

namespace KonradMichalik\Typo3EnvironmentIndicator\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * NonceViewHelper.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
class NonceViewHelper extends AbstractViewHelper
{
    public function render(): ?string
    {
        // TYPO3 v12+ has the Nonce class
        if (!class_exists(\TYPO3\CMS\Core\Security\Nonce::class)) {
            return null;
        }

        $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        $nonce = $request->getAttribute('nonce');

        // TYPO3 v12 uses Nonce directly
        // @phpstan-ignore instanceof.alwaysFalse (TYPO3 v12 compatibility - PHPStan uses v13 stubs)
        if ($nonce instanceof \TYPO3\CMS\Core\Security\Nonce) {
            return $nonce->b64;
        }

        // TYPO3 v13+ uses ConsumableNonce
        if (class_exists(\TYPO3\CMS\Core\Security\ContentSecurityPolicy\ConsumableNonce::class)
            && $nonce instanceof \TYPO3\CMS\Core\Security\ContentSecurityPolicy\ConsumableNonce
        ) {
            return $nonce->consume();
        }

        return null;
    }
}

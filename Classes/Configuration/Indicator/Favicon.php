<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "typo3_environment_indicator".
 *
 * Copyright (C) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;

/**
 * Favicon.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0
 */
class Favicon extends AbstractIndicator implements IndicatorInterface
{
    public function __construct(protected array $configuration = [], protected Scope $scope = Scope::Global, ?ServerRequestInterface $request = null)
    {
        parent::__construct($this->configuration, $request);
    }

    public function getConfiguration(): array
    {
        $request = $this->getRequest();
        $applicationType = $request !== null ? ApplicationType::fromRequest($request) : null;

        switch ($this->scope) {
            case Scope::Global:
                return $this->configuration;
            case Scope::Backend:
                if ($applicationType !== null && $applicationType->isBackend()) {
                    return $this->configuration;
                }
                break;
            case Scope::Frontend:
                if ($applicationType !== null && $applicationType->isFrontend()) {
                    return $this->configuration;
                }
                break;
        }
        return [];
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? null;
    }
}

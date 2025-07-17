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

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class FrontendUserGroup implements TriggerInterface
{
    protected array $groups;

    public function __construct(...$group)
    {
        $this->groups = $group;
    }

    public function check(): bool
    {
        // Deprecated: $GLOBALS['TSFE'] is deprecated since TYPO3 v13.
        $currentUserGroups = $GLOBALS['TSFE']->fe_user->groupData['uid'] ?? [];
        foreach ($this->groups as $group) {
            if (in_array($group, $currentUserGroups, true)) {
                return true;
            }
        }
        return false;
    }
}

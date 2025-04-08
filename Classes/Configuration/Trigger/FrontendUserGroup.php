<?php

declare(strict_types=1);

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

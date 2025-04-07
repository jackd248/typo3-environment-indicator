<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

class BackendUserGroup implements TriggerInterface
{
    protected array $groups;

    public function __construct(...$group)
    {
        $this->groups = $group;
    }

    public function check(): bool
    {
        $currentUserGroups = $GLOBALS['BE_USER']->userGroupsUID ?? [];
        foreach ($this->groups as $group) {
            if (in_array($group, $currentUserGroups, true)) {
                return true;
            }
        }
        return false;
    }
}

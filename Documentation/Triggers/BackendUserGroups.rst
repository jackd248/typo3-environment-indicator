..  include:: /Includes.rst.txt

..  _trigger-backend-user-groups:

============
Backend User Groups
============

The :code:`BackendUserGroups` trigger is used to show the indicators in the TYPO3 backend for specific backend user groups.

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler::addIndicator(
        triggers: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\BackendUserGroups(1,2)
        ],
        indicators: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar([
                'color' => '#00ACC1',
            ]),
        ]
    );

The configuration supports multiple group IDs, which are separated by a comma.

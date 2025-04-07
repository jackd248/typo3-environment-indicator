..  include:: /Includes.rst.txt

..  _trigger-frontend-user-groups:

============
Frontend User Groups
============

The :code:`FrontendUserGroups` trigger is used to show the indicators in the TYPO3 Frontend for specific frontend user groups.

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler::addIndicator(
        triggers: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\FrontendUserGroups(1,2)
        ],
        indicators: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar([
                'color' => '#00ACC1',
            ]),
        ]
    );

The configuration supports multiple group IDs, which are separated by a comma.

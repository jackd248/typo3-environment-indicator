..  include:: /Includes.rst.txt

..  _triggers:

============
Triggers
============

Triggers are used to define when environment indicators should be shown.

You can combine multiple different triggers to build up flexible conditions.

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler::addIndicator(
        triggers: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\ApplicationContext('Development'),
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\Admin()
        ],
        indicators: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar([
                'color' => '#00ACC1',
            ]),
        ]
    );

Their are several triggers available, which can be used to show the indicators in different contexts.


..  toctree::
    :maxdepth: 3

    Admin
    ApplicationContext
    BackendUserGroups
    Custom
    FrontendUserGroups
    Ip

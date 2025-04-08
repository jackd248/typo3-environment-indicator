..  include:: /Includes.rst.txt

..  _trigger-application-context:

============
Application Context
============

The :code:`ApplicationContext` trigger is used to show the indicators in the TYPO3 backend for a specific application context.

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler::addIndicator(
        triggers: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\ApplicationContext('Development*', 'Testing')
        ],
        indicators: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar([
                'color' => '#00ACC1',
            ]),
        ]
    );

The configuration supports multiple context names, which are separated by a comma. The context names can be prefixed with a wildcard `*` to match all contexts that start with the given name. For example, `Development*` will match all contexts that start with `Development`, such as `Development`, `Development/Local`, `Development/DDEV`, etc.

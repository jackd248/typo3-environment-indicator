..  include:: /Includes.rst.txt

..  _handler:

=======================
Handler
=======================

The :code:`Handler` class is used to register the indicators and triggers in the TYPO3 backend. The class provides a static method :code:`addIndicator()` to add the indicators and triggers to the system.

See the configuration for :ref:`triggers <triggers>` and :ref:`indicators <indicators>`.

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler::addIndicator(
        triggers: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\FrontendUserGroup(1,2)
        ],
        indicators: [
            new \KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\Backend\Topbar([
                'color' => '#00ACC1',
            ]),
        ]
    );

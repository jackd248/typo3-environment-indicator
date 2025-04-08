..  include:: /Includes.rst.txt

..  _backend-topbar:

=======================
Backend topbar
=======================

The backend toolbar item will show the current project version and environment.

..  figure:: /Images/backend-topbar.jpg
    :alt: Backend topbar
    :class: with-shadow

    Backend topbar

You can adjust the color of the topbar in your :code:`ext_localconf.php`:

..  code-block:: php
    :caption: ext_localconf.php

    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;

    Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Testing')
    ],
    indicators: [
        new Indicator\Backend\Topbar([
            'color' => '#bd593a',
        ])
    ]
);

Additional optional configuration keys:

- :code:`removeTransition` (bool): With this option you can remove the color to black transition on the right side of the topbar (not relevant for v13). Default is :code:`false`.

..  note::
    The backend topbar is a feature, which can also be shown in production environments. Use the :ref:`extension settings <extconf-backend.contextProduction>` to enable, disable or restrict it.

..  include:: /Includes.rst.txt

..  _backend-toolbar-item:

=======================
Backend toolbar item
=======================

The backend toolbar item will show the current project version and application context.

..  figure:: /Images/backend-toolbar-item.png
    :alt: Backend toolbar item
    :class: with-shadow

    Backend toolbar item

You can adjust the color of the toolbar item in your :code:`ext_localconf.php`:

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
        applicationContext: 'Development',
        backendToolbarConfiguration: [
            'color' => '#bd593a',
        ]
    );

Additional optional configuration keys:

- :code:`text` (string): The text of the toolbar item. Default is the application context.
- :code:`icon` (string): The icon of the toolbar item. Default is :code:`information-application-context`.
- :code:`index` (int): The positioning index of the toolbar item. Default is :code:`0`.

..  note::
    The backend toolbar item is the only feature, which can also be shown in production environments. Use the :ref:`extension settings <extconf-backend.contextProduction>` to enable, disable or restrict it.

..  include:: /Includes.rst.txt

..  _frontend-hint:

=======================
Frontend Hint
=======================

The frontend hint will show the current application context information and the website title as clickable note in the upper right corner.

..  figure:: /Images/frontend-hint.png
    :alt: Frontend hint
    :class: with-shadow

    Frontend hint

You can adjust the color of the hint in your :code:`ext_localconf.php`:

..  code-block:: php
    :caption: ext_localconf.php

    \KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
        applicationContext: 'Development',
        frontendHintConfiguration: [
            'color' => '#bd593a',
        ],
    );

Additional optional configuration keys:

- :code:`text` (string): The text of the hint. Default is the website title.
- :code:`position` (string): The position of the frontend hint. Default is :code:`top left`. Possible values are :code:`bottom left`,
:code:`bottom right`, :code:`top left`, :code:`top right`.

..  include:: /Includes.rst.txt

..  _backend-logo:

=======================
Backend Logo
=======================

The backend logo will be modified regarding the environment and the associated
configuration.

..  figure:: /Images/preview-backend-logo.jpg
    :alt: Backend Logo Example

    Backend Logo Example


The backend logo will be fetched by the extension configuration of
:code:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendLogo']`.

Modifiers
**********

The backend logo modification is identical to the :ref:`favicon modification <favicon-modifiers>`. You can use the same modifiers and configuration.

..  code-block:: php
    :caption: ext_localconf.php

    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Handler;
    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;
    use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger;
    use KonradMichalik\Typo3EnvironmentIndicator\Image;

    Configuration\Handler::addIndicator(
    triggers: [
        new Trigger\ApplicationContext('Testing')
    ],
    indicators: [
        new Indicator\Backend\Logo([
            new Image\TextModifier([
                'text' => 'TEST',
                'color' => '#f39c12',
                'stroke' => [
                    'color' => '#ffffff',
                    'width' => 3,
                ],
            ])
        ])
    ]
);

..  figure:: /Images/Favicons/typo3-test.png
    :alt: Backend Logo Modifier Example

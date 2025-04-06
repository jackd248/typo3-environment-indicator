..  include:: /Includes.rst.txt

..  _configuration-utility:

=======================
Configuration Utility
=======================

Generally the whole configuration can be found in
:code:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_environment_indicator']`.
You can/should use the :code:`ConfigurationUtility::configByContext()` to easily add
necessary configuration for the environment indicator.

..  code-block:: php
    :caption: ext_localconf.php

    // Add a colorized favicon modifier, add a colorful backend toolbar item and unset the frontend hint for the Development context
    \KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::configByContext(
        applicationContext: 'Development',
        faviconModifierConfiguration: [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class =>
            [
                'color' => '#039BE5',
            ]
        ],
        faviconModifierFrontendConfiguration: [
            \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class =>
            [
                'opacity' => 0.5 // Change just the opacity for the frontend favicon configuration
            ]
        ],
        frontendHintConfiguration: null, // Unset frontend hint for Development context
        backendToolbarConfiguration: [
            'color' => '#039BE5',
        ]
    );

..  php:namespace:: KonradMichalik\Typo3EnvironmentIndicator\Utility

..  php:class:: ConfigurationUtility

    Utility class to easily configure the environment indicators.

    ..  php:method:: configByContext($applicationContext, $frontendHintConfiguration = [], $backendToolbarConfiguration = [], $faviconModifierConfiguration = [], $faviconModifierFrontendConfiguration = [], $faviconModifierBackendConfiguration = [])

        Simple function to update the status of a record.

        :param string $applicationContext: Name of the TYPO3 application context.
        :param array|null $frontendHintConfiguration: Configuration for the :ref:`frontend hint <frontend-hint>`. Set to :code:`null` to unset the configuration.
        :param array|null $backendToolbarConfiguration: Configuration for the :ref:`backend toolbar item <backend-toolbar-item>`. Set to :code:`null` to unset the configuration.
        :param array|null $backendTopbarConfiguration: Configuration for the :ref:`backend topbar <backend-topbar>`. Set to :code:`null` to unset the configuration.
        :param array|null $faviconModifierConfiguration: Configuration for the :ref:`favicon modification <favicon-modifiers>`. This configuration applies to frontend and backend. Set to :code:`null` to unset the configuration.
        :param array|null $faviconModifierFrontendConfiguration: **Frontend** configuration for the :ref:`favicon modification <favicon-modifiers>`. Set to :code:`null` to unset the configuration.
        :param array|null $faviconModifierBackendConfiguration: **Backend** configuration for the :ref:`favicon modification <favicon-modifiers>`. Set to :code:`null` to unset the configuration.
        :param array|null $backendLogoModifierConfiguration: Configuration for the :ref:`backend logo modification <backend-logo>`. Set to :code:`null` to unset the configuration.
        :param array|null $frontendImageModifierConfiguration: Configuration for the :ref:`frontend image modification <frontend-image>`. Set to :code:`null` to unset the configuration.
        :returntype: :php:`void`

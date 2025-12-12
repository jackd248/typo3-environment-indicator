..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

..  _requirements:

Requirements
============

-   PHP 8.1 - 8.4
-   TYPO3 13.4 LTS
-   ImageDriver: GD, Imagick or libvips

..  _steps:

Installation
============

Require the extension via Composer (recommended):

..  code-block:: bash

    composer require konradmichalik/typo3-environment-indicator

Or download it from the
`TYPO3 extension repository <https://extensions.typo3.org/extension/typo3_environment_indicator>`__.

Configuration
============

Include the static TypoScript template "Environment Indicator" or directly import it in your sitepackage:


..  code-block:: typoscript
    :caption: Configuration/TypoScript/setup.typoscript

    @import 'EXT:typo3_environment_indicator/Configuration/TypoScript/setup.typoscript'

..  note::
    This is only necessary if you want to use the :ref:`frontend hint <frontend-hint>`.

Image Support
============

Only the following favicon image formats are supported: https://image.intervention.io/v3/introduction/formats

* Due to the wide distribution of :code:`.ico` and :code:`.svg` files, these images are also supported.

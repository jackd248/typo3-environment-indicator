..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

..  _requirements:

Requirements
============

-   PHP 8.2 - 8.5
-   TYPO3 13.4 LTS & 14.0
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
=============

..  note::
    TypoScript configuration is only necessary if you want to use the :ref:`frontend hint <frontend-hint>`.

Site Set (Recommended)
----------------------

Add the site set as a dependency in your site configuration:

..  code-block:: yaml
    :caption: config/sites/<identifier>/config.yaml

    base: 'https://example.com/'
    rootPageId: 1
    dependencies:
      - konradmichalik/typo3-environment-indicator

Static Include (Legacy)
-----------------------

Alternatively, include the static TypoScript template via the **Template** module
by adding "Environment Indicator" under **Include static (from extensions)**.

Or directly import it in your sitepackage:

..  code-block:: typoscript
    :caption: Configuration/TypoScript/setup.typoscript

    @import 'EXT:typo3_environment_indicator/Configuration/TypoScript/setup.typoscript'

Image Support
============

Only the following favicon image formats are supported: https://image.intervention.io/v3/introduction/formats

* Due to the wide distribution of :code:`.ico` and :code:`.svg` files, these images are also supported.

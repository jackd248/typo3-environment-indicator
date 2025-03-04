..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

..  _requirements:

Requirements
============

-   PHP 8.1 - 8.4
-   TYPO3 11.5 LTS - 13.4 LTS
-   ImageMagick

    -    Required for the `.ico` favicon file modification

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

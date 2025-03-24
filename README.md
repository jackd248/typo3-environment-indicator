<div align="center">

![Extension icon](Resources/Public/Icons/Extension.svg)

# TYPO3 extension `typo3_environment_indicator`

[![Latest Stable Version](https://typo3-badges.dev/badge/typo3_environment_indicator/version/shields.svg)](https://extensions.typo3.org/extension/typo3_environment_indicator)
[![Supported TYPO3 versions](https://typo3-badges.dev/badge/typo3_environment_indicator/typo3/shields.svg)](https://extensions.typo3.org/extension/typo3_environment_indicator)
[![License](https://poser.pugx.org/konradmichalik/typo3-environment-indicator/license)](LICENSE.md)

</div>

This extension provides several features to show an environment indicator in the TYPO3 frontend and backend.

| Preview                                                                         | Feature                                                                                                                                                                        |
|---------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| ![Frontend Hint Preview](Documentation/Images/preview-frontend-hint.png)        | **[Frontend hint](https://docs.typo3.org/p/konradmichalik/typo3-environment-indicator/main/en-us/Configuration/FrontendHint.html)** <br/><br/> Adds an informative hint to the frontend showing the website title and the current application context.                         |
| ![Backend Toolbar Item Preview](Documentation/Images/preview-backend-toolbar-item.png) | **[Backend toolbar item](https://docs.typo3.org/p/konradmichalik/typo3-environment-indicator/main/en-us/Configuration/BackendToolbar.html)** <br/><br/> Adds an informative item with the current application context to the backend toolbar.                             |
| ![Backend Topbar Preview](Documentation/Images/preview-backend-topbar.jpg) | **[Backend topbar](https://docs.typo3.org/p/konradmichalik/typo3-environment-indicator/main/en-us/Configuration/BackendTopbar.html)** <br/><br/> Colorize the backend header topbar regarding the application context.                             |
| ![Favicon Preview](Documentation/Images/preview-favicon.png)                    | **[Modified favicon](https://docs.typo3.org/p/konradmichalik/typo3-environment-indicator/main/en-us/Configuration/Favicon.html)** <br/><br/> Modify the favicon for frontend and backend based on the original favicon, the current application context and your configuration. |

> [!NOTE]  
> These environment indicators are mainly for development purposes (e.g. distinguishing between different test systems)
> and will not show in production environments.

## Requirements

- TYPO3 >= 11.5 & PHP 8.1+

## Installation

### Composer

[![Packagist](https://img.shields.io/packagist/v/konradmichalik/typo3-environment-indicator?label=version&logo=packagist)](https://packagist.org/packages/konradmichalik/typo3-environment-indicator)
[![Packagist Downloads](https://img.shields.io/packagist/dt/konradmichalik/typo3-environment-indicator?color=brightgreen)](https://packagist.org/packages/konradmichalik/typo3-environment-indicator)

Use the following composer command to install the extension:

```bash
composer require konradmichalik/typo3-environment-indicator
```

### TER

[![TER version](https://typo3-badges.dev/badge/typo3_environment_indicator/version/shields.svg)](https://extensions.typo3.org/extension/typo3_environment_indicator)
[![TER downloads](https://typo3-badges.dev/badge/typo3_environment_indicator/downloads/shields.svg)](https://extensions.typo3.org/extension/typo3_environment_indicator)

Download the zip file from [TYPO3 extension repository (TER)](https://extensions.typo3.org/extension/typo3_environment_indicator).

## Documentation

Please have a look at the
[official extension documentation](https://docs.typo3.org/p/konradmichalik/typo3-environment-indicator/main/en-us/Index.html).

## Development

Use the following ddev command to easily install all supported TYPO3 versions for locale development.

```bash
ddev install all
```

Use the `context` command to easily change the application context in all supported TYPO3 versions.

## Credits

This project is partly inspired by the [laravel-favicon](https://github.com/beyondcode/laravel-favicon) package.

## License

This project is licensed
under [GNU General Public License 2.0 (or later)](LICENSE.md).

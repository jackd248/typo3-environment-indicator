<div align="center">

![Extension icon](Resources/Public/Icons/Extension.svg)

# TYPO3 extension `typo3_environment_indicator`

</div>

[![Supported TYPO3 versions](https://badgen.net/badge/TYPO3/11%20&%2012%20&%2013/orange)]()
[![License](https://poser.pugx.org/xima/xima-typo3-content-planner/license)](LICENSE.md)

This extension provides several features to show an environment indicator in the TYPO3 frontend and backend.

| Preview                                                                         | Feature                                                                                                                                                                        |
|---------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| ![Frontend Hint Preview](Documentation/Images/preview-frontend-hint.png)        | **[Frontend hint](#frontend-hint)** <br/><br/> Adds an informative hint to the frontend showing the website title and the current application context.                         |
| ![Frontend Hint Preview](Documentation/Images/preview-backend-toolbar-item.png) | **[Backend toolbar item](#backend-toolbar-item)** <br/><br/> Adds an informative item with the current application context to the backend toolbar.                             |
| ![Favicon Preview](Documentation/Images/preview-favicon.png)                    | **[Modified favicon](#favicon)** <br/><br/> Modify the favicon for frontend and backend based on the original favicon, the current application context and your configuration. |

> [!NOTE]  
> These environment indicators are mainly for development purposes (e.g. distinguishing between different test systems)
> and will not show in production environments.

## Table of contents

* [Requirements](#requirements)
* [Installation](#installation)
    + [Composer](#composer)
    + [Configuration](#configuration)
    + [Extension settings](#extension-settings)
* [Frontend hint](#frontend-hint)
* [Backend toolbar item](#backend-toolbar-item)
* [Favicon](#favicon)
    + [Modification](#modification)
        - [TextModifier](#textmodifier)
        - [TriangleModifier](#trianglemodifier)
        - [CircleModifier](#circlemodifier)
        - [FrameModifier](#framemodifier)
        - [ReplaceModifier](#replacemodifier)
        - [ColorizeModifier](#colorizemodifier)
        - [CustomModifier](#custommodifier)
    + [ConfigurationUtility](#configurationutility)
* [Development](#development)
* [Credits](#credits)
* [License](#license)


## Requirements

* TYPO3 >= 11.5 & PHP 8.1+
* ImageMagick
    * Required for the `.ico` favicon file modification

## Installation

### Composer

Use the following composer command to install the extension:

```bash
composer require konradmichalik/typo3-environment-indicator
```

### Configuration

Include the static TypoScript template "Environment Indicator" or directly import it in your sitepackage:

```typoscript
@import 'EXT:typo3_environment_indicator/Configuration/TypoScript/setup.typoscript'
```

### Extension settings

You can enable and disable every single feature in the extension settings.

## Frontend hint

The frontend hint will show the current application context information and the website title as clickable note in the
upper right corner.

![Favicon TYPO3 Text](Documentation/Images/frontend-hint.png)

You can adjust the color of the hint in your `ext_localconf.php`:

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFrontendHintConfigurationByContext(
    'Development',
    [
        'color' => '#bd593a',
    ]
);
```

Additional optional configuration keys:

- `text` (string): The text of the hint. Default is the website title.
- `position` (string): The position of the frontend hint. Default is `top left`. Possible values are `bottom left`,
  `bottom right`, `top left`, `top right`.


## Backend toolbar item

The backend toolbar item will show the current project version and application context.

![Favicon TYPO3 Text](Documentation/Images/backend-toolbar-item.png)

You can adjust the color of the toolbar item in your `ext_localconf.php`:

```php
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['typo3_environment_indicator']['context']['Development']['backendToolbar'] => [
    'color' => '#bd593a',
]
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addBackendToolbarConfigurationByContext(
    'Development',
    [
        'color' => '#bd593a',
    ]
);
```

Additional optional configuration keys:

- `text` (string): The text of the toolbar item. Default is the application context.
- `icon` (string): The icon of the toolbar item. Default is `information-application-context`.

## Favicon

The favicon of the frontend or backend context will be modified regarding the application context and the associated
configuration.

For the **frontend**, the original favicon will either be fetched from the typoscript configuration
`page.shortcutIcon` (
see [typoscript reference](https://docs.typo3.org/m/typo3/reference-typoscript/main/en-us/Guide/Page/Index.html#guide-page-favicon))
or can be handled by your own fluid template via the [FaviconViewHelper](Classes/ViewHelpers/FaviconViewHelper.php):

```html
<html xmlns:env="http://typo3.org/ns/KonradMichalik/Typo3EnvironmentIndicator/ViewHelpers" data-namespace-typo3-fluid="true">

{f:uri.resource(path:'EXT:your_extension/Resources/Public/Favicon/favicon.png') -> env:favicon()}
```

For the **backend**, the favicon will be fetched by the extension configuration of
`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['backend']['backendFavicon']`.

![Favicon Examples](Documentation/Images/favicon-examples.png)

### Modification

The favicon modification configuration can be found in
`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['typo3_environment_indicator']`.

Add a configured favicon modifier to the desired application context (e.g. `Testing`) in your `ext_localconf.php`:

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Testing',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class,
    [
        'text' => 'TEST',
         'color' => '#f39c12',
        'stroke' => [
            'color' => '#ffffff',
            'width' => 3,
        ],
    ]
);
```

![Favicon TYPO3 Text](Documentation/Images/Favicons/typo3-test.png)

The modifiers will be executed one after the other. You can combine them if you want.

> [!NOTE]
> If you want to specify the frontend or backend favicon separately, you can add the third parameter for the request context `frontend` or `backend` to the `addFaviconModifierConfigurationByContext()` method.

The following modifier classes are available:

#### [TextModifier](Classes/Image/TextModifier.php)

> This is the default modifier if no own configuration is set.

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TextModifier::class,
    [
        'text' => 'DEV',
        'color' => '#bd593a',
        'stroke' => [
            'color' => '#ffffff',
            'width' => 3,
        ],
    ]
);
```

![Favicon TYPO3 Text](Documentation/Images/Favicons/typo3-text.png)

Additional optional configuration keys:

- `font` (string): The font file path for the text. Default is
  `EXT:typo3_environment_indicator/Resources/Public/Fonts/OpenSans-Bold.ttf`.
- `position` (string): The position of the text. Default is `bottom`. Possible values are `bottom`, `top`.

<hr/>

#### [TriangleModifier](Classes/Image/TriangleModifier.php)

Adds a triangle indicator to the favicon.

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class,
    [
        'color' => '#bd593a',
    ]
);
```

![Favicon TYPO3 Triangle](Documentation/Images/Favicons/typo3-triangle.png)

Additional optional configuration keys:

- `size` (float): The percentage size of the triangle. Default is `0.7`.
- `position` (string): The position of the triangle. Default is `bottom right`. Possible values are `bottom left`,
  `bottom right`, `top left`, `top right`.

<hr/>

#### [CircleModifier](Classes/Image/CircleModifier.php)

Adds a circle indicator to the favicon.

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Circle',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\CircleModifier::class,
    [
        'color' => '#bd593a',
    ]
);
```

![Favicon TYPO3 Circle](Documentation/Images/Favicons/typo3-circle.png)

Additional optional configuration keys:

- `size` (float): The percentage size of the circle. Default is `0.4`.
- `position` (string): The position of the circle. Default is `bottom right`. Possible values are `bottom left`,
  `bottom right`, `top left`, `top right`.
- `padding` (float): The percentage padding of the circle. Default is `0.1`.

<hr/>

#### [FrameModifier](Classes/Image/FrameModifier.php)

Adds a frame around the favicon.

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\FrameModifier::class,
    [
        'color' => '#bd593a',
    ]
);
```

![Favicon TYPO3 Text](Documentation/Images/Favicons/typo3-frame.png)

Additional optional configuration keys:

- `borderSize` (float): The border size of the frame. Default is `5`.

<hr/>

#### [ReplaceModifier](Classes/Image/ReplaceModifier.php)

Replace the original favicon with a custom one regarding the application context.

```php
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['typo3_environment_indicator']['context']['Development']['favicon'] => [
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ReplaceModifier::class => [
        'path' => 'EXT:sitepackage/Resources/Public/Icons/favicon.png',
    ],
]
```

![Favicon TYPO3 Replace](Documentation/Images/Favicons/replace.png)

<hr/>

#### [ColorizeModifier](Classes/Image/ColorizeModifier.php)

Colorize the original favicon in a desired color regarding the application context.

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development/Colorize',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\ColorizeModifier::class,
    [
        'color' => '#039BE5',
    ],
);
```

![Favicon TYPO3 Colorize](Documentation/Images/Favicons/typo3-colorize.png)

Additional optional configuration keys:

- `opacity` (float): Controls the opacity of the colorization. Default is `1`.

<hr/>

#### CustomModifier

Implement your own image modifier by extending the [AbstractModifier](Classes/Image/AbstractModifier.php) class and
implementing the [ModifierInterface](Classes/Image/ModifierInterface.php) method.

```php
<?php

namespace Vendor\YourExt\Image;

use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Interfaces\ImageInterface;
    
class CustomModifier extends AbstractModifier implements ModifierInterface {

    public function modify(ImageInterface &$image): void 
    {
        // Modify the image
    }

    public function getRequiredConfigurationKeys(): array 
    {
        // Return the required configuration keys
    }
}
```

See the [Intervention Image documentation](http://image.intervention.io/v3) for more information about image
manipulation.

> [!NOTE]  
> Having fun with colorful favicons? Use the [ColorUtility::getColoredString()](Classes/Utility/ColorUtility.php)
> function as color entry in your modifier configuration to generate a color based on a string (default is the
`$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']`).

### ConfigurationUtility

Generally the whole configuration can be found in `$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_environment_indicator']`. 
You can/should use the [ConfigurationUtility](Classes/Utility/ConfigurationUtility.php) to easily add necessary configuration for the environment indicator.

```php
// Add a triangle favicon modifier configuration for the Development context
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class
);
// Helper method to add the color configuration for the Development context fot the backend toolbar and all previously configured favicon modifiers
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addMainColorConfigurationByContext(
    'Development',
    '#bd593a',
    \KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::OPTION_BACKEND_TOOLBAR | \KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::OPTION_FAVICON // If this is not set, the color will applied to all features
);
```

The previous example is equivalent to the following configuration:

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addFaviconModifierConfigurationByContext(
    'Development',
    \KonradMichalik\Typo3EnvironmentIndicator\Image\TriangleModifier::class,
    [
        'color' => '#bd593a',
    ]
);
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addBackendToolbarConfigurationByContext(
    'Development',
    [
        'color' => '#bd593a',
    ]
);
```

You can also unset a feature for a specific context when setting the configuration to `null`:

```php
\KonradMichalik\Typo3EnvironmentIndicator\Utility\ConfigurationUtility::addBackendToolbarConfigurationByContext(
    'Testing',
    null
);
```
## Development

Use the following ddev command to easily install all supported TYPO3 versions for locale development.

```bash
$ ddev install
```

## Credits

This project is partly inspired by the [laravel-favicon](https://github.com/beyondcode/laravel-favicon) package.

## License

This project is licensed
under [GNU General Public License 2.0 (or later)](LICENSE.md).

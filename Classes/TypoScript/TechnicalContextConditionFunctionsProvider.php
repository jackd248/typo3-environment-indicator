<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\TypoScript;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;

class TechnicalContextConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function __construct(
        protected readonly ExtensionConfiguration $extensionConfiguration
    ) {
    }

    public function getFunctions(): array
    {
        return [
            $this->getWebserviceFunction(),
        ];
    }

    protected function getWebserviceFunction(): ExpressionFunction
    {
        $extensionConfiguration = $this->extensionConfiguration;
        return new ExpressionFunction(
            'enableTechnicalContext',
            static fn () => null,
            static function () use ($extensionConfiguration) {
                return $extensionConfiguration->get(Configuration::EXT_KEY)['frontend']['context'] &&
                    in_array(Environment::getContext()->__toString(), array_keys($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context']));
            }
        );
    }
}

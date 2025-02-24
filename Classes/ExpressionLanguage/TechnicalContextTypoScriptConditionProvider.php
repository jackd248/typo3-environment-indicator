<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\ExpressionLanguage;

use KonradMichalik\Typo3EnvironmentIndicator\TypoScript\TechnicalContextConditionFunctionsProvider;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

class TechnicalContextTypoScriptConditionProvider extends AbstractProvider
{
    public function __construct()
    {
        $this->expressionLanguageProviders = [
            TechnicalContextConditionFunctionsProvider::class,
        ];
    }
}

<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\HandlerType;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ApplicationType;

class FaviconHandler extends AbstractImageHandler
{
    public function __construct()
    {
        parent::__construct(Scope::Both, HandlerType::Favicon);
    }

    protected function getEnvironmentImageModifiers(ServerRequestInterface $request): array
    {
        $configuration = isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()][$this->scope->value][$this->type->value]) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()][$this->scope->value][$this->type->value] : [];
        if (ApplicationType::fromRequest($request)->isFrontend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['frontend'][$this->type->value] ?? []);
        } elseif (ApplicationType::fromRequest($request)->isBackend()) {
            $configuration = $this->mergeConfigurationRecursiveOrdered($configuration, $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()]['backend'][$this->type->value] ?? []);
        }
        return $configuration;
    }
}

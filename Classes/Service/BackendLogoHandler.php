<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use KonradMichalik\Typo3EnvironmentIndicator\Configuration;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\HandlerType;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;

class BackendLogoHandler extends AbstractImageHandler
{
    public function __construct()
    {
        parent::__construct(Scope::Backend, HandlerType::Logo);
    }

    protected function getEnvironmentImageModifiers(ServerRequestInterface $request): array
    {
        return isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()][$this->scope->value][$this->type->value]) ?
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['context'][Environment::getContext()->__toString()][$this->scope->value][$this->type->value] : [];
    }
}

<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator;

use KonradMichalik\Typo3EnvironmentIndicator\Enum\Scope;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;

class Favicon extends AbstractIndicator implements IndicatorInterface
{
    public function __construct(protected array $configuration = [], protected Scope $scope = Scope::Global, ?ServerRequestInterface $request = null)
    {
        parent::__construct($this->configuration, $request);
    }

    public function getConfiguration(): array
    {
        // @todo: check if this is the right way to get the request
        $request = $this->getRequest();
        $applicationType = $request ? ApplicationType::fromRequest($request) : null;

        switch ($this->scope) {
            case Scope::Global:
                return $this->configuration;
            case Scope::Backend:
                if ($applicationType && $applicationType->isBackend()) {
                    return $this->configuration;
                }
                break;
            case Scope::Frontend:
                if ($applicationType && $applicationType->isFrontend()) {
                    return $this->configuration;
                }
                break;
        }
        return [];
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return null;
    }
}

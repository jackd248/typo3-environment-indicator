<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Model;

use KonradMichalik\Typo3EnvironmentIndicator\Enum\FaviconType;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use TYPO3\CMS\Core\Core\Environment;

class Favicon
{
    protected FaviconType $type;
    protected string $filename;
    protected string $text;
    protected string $color;
    protected string $image;

    public function __construct(
        protected string $originalFavicon,
    ) {
        $this->type = FaviconType::from(GeneralHelper::getFaviconConfiguration('type'));
        $this->filename = $this->generateFaviconName();
    }

    public function getText(): string
    {
        return GeneralHelper::getFaviconConfiguration('text');
    }

    public function getStrokeColor(): string
    {
        return GeneralHelper::getFaviconConfiguration('stroke_color');
    }

    public function getStrokeWidth(): int
    {
        return (int)GeneralHelper::getFaviconConfiguration('stroke_width');
    }

    public function getColor(): string
    {
        return GeneralHelper::getFaviconConfiguration('color');
    }

    public function getImage(): string
    {
        return GeneralHelper::getFaviconConfiguration('image');
    }

    public function getOriginalFavicon(): string
    {
        return $this->originalFavicon;
    }

    /**
    * @return \KonradMichalik\Typo3EnvironmentIndicator\Enum\FaviconType
    */
    public function getType(): FaviconType
    {
        return $this->type;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    private function generateFaviconName(): string
    {
        $parts = [
            $this->getOriginalFavicon(),
            $this->getType()->value,
            Environment::getContext()->__toString(),
        ];
        return md5(implode('_', $parts));
    }
}

<?php

declare(strict_types=1);

namespace KonradMichalik\Typo3EnvironmentIndicator\Service;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;
use KonradMichalik\Typo3EnvironmentIndicator\Enum\FaviconType;
use KonradMichalik\Typo3EnvironmentIndicator\Model\Favicon;
use KonradMichalik\Typo3EnvironmentIndicator\Utility\GeneralHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FaviconHandler implements HandlerInterface
{
    public function process(string $path): string
    {
        $favicon = new Favicon($path);
        if ($favicon->getType() === FaviconType::IMAGE) {
            return $favicon->getImage();
        }

        $manager = new ImageManager(
            new Driver()
        );

        $newImageFilename = $favicon->getFilename() . '.png';
        $newImagePath = GeneralHelper::getFaviconFolder(false) . $newImageFilename;
        if ($path === $newImagePath) {
            return $newImagePath;
        }
        $image = $manager->read(GeneralUtility::getFileAbsFileName($path));

        switch ($favicon->getType()) {
            case FaviconType::TEXT:
                $this->addDynamicTextToFavicon($image, $favicon);
                break;
            case FaviconType::BORDER:
                break;
            default:
                break;
        }

        $image->save(GeneralHelper::getFaviconFolder() . $newImageFilename);
        return $newImagePath;
    }

    public function shouldProcess(): bool
    {
        return true;
    }

    protected function addDynamicTextToFavicon(ImageInterface $image, Favicon $favicon): void
    {
        $padding = 5;
        $maxWidth = $image->width() - 4;
        $maxHeight = $image->height() / 2;

        $text = $favicon->getText();
        $fontPath = GeneralHelper::getFaviconFont();
        $fontSize = 10;

        do {
            $fontSize++;
            $wrappedText = wordwrap($text, (int)($maxWidth / ($fontSize * 0.4)), "\n", true);
            $lines = explode("\n", $wrappedText);
            $estimatedHeight = count($lines) * $fontSize * 1.2;
        } while ($estimatedHeight < $maxHeight && $fontSize < 50);
        $fontSize--;

        $image->text($wrappedText, $image->width() / 2, $image->height() - $padding, function (FontFactory $font) use ($image, $fontSize, $favicon, $fontPath) {
            $font->filename($fontPath);
            $font->size($fontSize);
            $font->color($favicon->getColor());
            if ($favicon->getStrokeColor() !== null) {
                $font->stroke($favicon->getStrokeColor(), $favicon->getStrokeWidth() ?? 1);
            }
            $font->align('center');
            $font->valign('bottom');
        });
    }
}

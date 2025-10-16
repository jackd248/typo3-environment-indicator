<?php

declare(strict_types=1);

/*
 * This file is part of the "typo3_environment_indicator" TYPO3 CMS extension.
 *
 * (c) 2025 Konrad Michalik <hej@konradmichalik.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KonradMichalik\Typo3EnvironmentIndicator\Tests\Unit\Configuration\Service;

use Exception;
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Indicator\{Favicon, IndicatorInterface};
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Service\{ConfigurationStorage, IndicatorResolver, TriggerEvaluator};
use KonradMichalik\Typo3EnvironmentIndicator\Configuration\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * IndicatorResolverTest.
 *
 * @author Konrad Michalik <hej@konradmichalik.dev>
 * @license GPL-2.0-or-later
 */
final class IndicatorResolverTest extends TestCase
{
    public function testResolveIndicatorsReturnsCachedIndicators(): void
    {
        $storage = $this->createMock(ConfigurationStorage::class);
        $storage->method('hasCurrentIndicators')->willReturn(true);
        $storage->method('getCurrentIndicators')->willReturn([Favicon::class => ['color' => 'red']]);

        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);
        $result = $resolver->resolveIndicators();

        self::assertEquals([Favicon::class => ['color' => 'red']], $result);
    }

    public function testResolveIndicatorsProcessesConfigurationsWhenNotCached(): void
    {
        $indicator = $this->createMock(IndicatorInterface::class);
        $indicator->method('getConfiguration')->willReturn(['test' => 'value']);

        $configurations = [
            [
                'triggers' => [],
                'indicators' => [$indicator],
            ],
        ];

        $storage = $this->createMock(ConfigurationStorage::class);
        $storage->method('hasCurrentIndicators')->willReturn(false);
        $storage->method('getConfigurations')->willReturn($configurations);
        $storage->method('getCurrentIndicators')->willReturn([]);
        $storage->expects(self::once())
            ->method('mergeCurrentIndicator')
            ->with($indicator::class, ['test' => 'value']);

        $evaluator = $this->createMock(TriggerEvaluator::class);
        $evaluator->method('evaluateTriggers')->willReturn(true);

        $resolver = new IndicatorResolver($storage, $evaluator);
        $resolver->resolveIndicators();
    }

    public function testResolveIndicatorsSkipsConfigurationWhenTriggersDoNotPass(): void
    {
        $indicator = $this->createMock(IndicatorInterface::class);
        $trigger = $this->createMock(TriggerInterface::class);

        $configurations = [
            [
                'triggers' => [$trigger],
                'indicators' => [$indicator],
            ],
        ];

        $storage = $this->createMock(ConfigurationStorage::class);
        $storage->method('hasCurrentIndicators')->willReturn(false);
        $storage->method('getConfigurations')->willReturn($configurations);
        $storage->method('getCurrentIndicators')->willReturn([]);
        $storage->expects(self::never())
            ->method('mergeCurrentIndicator');

        $evaluator = $this->createMock(TriggerEvaluator::class);
        $evaluator->method('evaluateTriggers')->willReturn(false);

        $resolver = new IndicatorResolver($storage, $evaluator);
        $resolver->resolveIndicators();
    }

    public function testResolveIndicatorsSkipsConfigurationWhenNoIndicators(): void
    {
        $configurations = [
            [
                'triggers' => [],
                'indicators' => [],
            ],
        ];

        $storage = $this->createMock(ConfigurationStorage::class);
        $storage->method('hasCurrentIndicators')->willReturn(false);
        $storage->method('getConfigurations')->willReturn($configurations);
        $storage->method('getCurrentIndicators')->willReturn([]);
        $storage->expects(self::never())
            ->method('mergeCurrentIndicator');

        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);
        $resolver->resolveIndicators();
    }

    public function testResolveIndicatorsHandlesExceptionInIndicatorProcessing(): void
    {
        $indicator = $this->createMock(IndicatorInterface::class);
        $indicator->method('getConfiguration')->willThrowException(new Exception('Test exception'));

        $configurations = [
            [
                'triggers' => [],
                'indicators' => [$indicator],
            ],
        ];

        $storage = $this->createMock(ConfigurationStorage::class);
        $storage->method('hasCurrentIndicators')->willReturn(false);
        $storage->method('getConfigurations')->willReturn($configurations);
        $storage->method('getCurrentIndicators')->willReturn([]);

        $evaluator = $this->createMock(TriggerEvaluator::class);
        $evaluator->method('evaluateTriggers')->willReturn(true);

        $resolver = new IndicatorResolver($storage, $evaluator);
        $result = $resolver->resolveIndicators();

        self::assertEquals([], $result);
    }

    public function testValidateIndicatorsReturnsTrueForValidIndicators(): void
    {
        $storage = $this->createMock(ConfigurationStorage::class);
        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);

        $favicon = new Favicon();
        self::assertTrue($resolver->validateIndicators([$favicon]));
    }

    public function testValidateIndicatorsReturnsTrueForEmptyArray(): void
    {
        $storage = $this->createMock(ConfigurationStorage::class);
        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);

        self::assertTrue($resolver->validateIndicators([]));
    }

    public function testValidateIndicatorsReturnsFalseForInvalidIndicators(): void
    {
        $storage = $this->createMock(ConfigurationStorage::class);
        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);

        self::assertFalse($resolver->validateIndicators(['invalid']));
    }

    public function testValidateIndicatorsReturnsFalseWhenOneIndicatorIsInvalid(): void
    {
        $storage = $this->createMock(ConfigurationStorage::class);
        $evaluator = $this->createMock(TriggerEvaluator::class);

        $resolver = new IndicatorResolver($storage, $evaluator);

        $favicon = new Favicon();
        $invalid = new stdClass();

        self::assertFalse($resolver->validateIndicators([$favicon, $invalid]));
    }
}

<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Tests\Unit\Infrastructure\LoggerProcessor;

use PHPUnit\Framework\TestCase;
use Vasary\XTraceId\Infrastructure\LoggerProcessor\ExtraParametersProcessor;


final class ExtraParametersProcessorTest extends TestCase
{
    public const TEST_PARAMETERS = [
        'envaironment' => 'test',
        'some_var' => 'some_value',
    ];

    /**
     * @test
     */
    public function success(): void
    {
        $fieldName = ExtraParametersProcessor::FIELD_NAME;

        $processor = new ExtraParametersProcessor(self::TEST_PARAMETERS);
        $record = $processor([]);

        self::assertArrayHasKey($fieldName, $record);
        self::assertEquals(self::TEST_PARAMETERS, $record[$fieldName]);
    }
}

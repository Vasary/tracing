<?php

declare(strict_types=1);

namespace Vasary\XTraceId\Infrastructure\GUIDGenerator;

use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;

final class GUIDGenerator implements GUIDGeneratorInterface
{
    public function v4(): string
    {
        mt_srand(random_int(PHP_INT_MIN, PHP_INT_MAX));

        $chard = strtolower(md5(uniqid((string)mt_rand(), true)));
        $hyphen = chr(45);

        return
            substr($chard, 0, 8) . $hyphen .
            substr($chard, 8, 4) . $hyphen .
            substr($chard, 12, 4) . $hyphen .
            substr($chard, 16, 4) . $hyphen .
            substr($chard, 20, 12)
        ;
    }
}

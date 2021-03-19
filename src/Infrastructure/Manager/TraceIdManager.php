<?php

namespace Vasary\XTraceId\Infrastructure\Manager;

use Vasary\XTraceId\Domain\GUIDGenerator\GUIDGeneratorInterface;
use Vasary\XTraceId\Domain\Manager\TraceIdManagerInterface;
use Vasary\XTraceId\Domain\Storage\TraceIdStorageInterface;
use Vasary\XTraceId\Domain\ValueObject\TraceId;

final class TraceIdManager implements TraceIdManagerInterface
{
    private $generator;
    private $storage;

    public function __construct(GUIDGeneratorInterface $generator, TraceIdStorageInterface $storage)
    {
        $this->generator = $generator;
        $this->storage = $storage;

        $this->create($this->generator->v4());
    }

    public function create(string $id): void
    {
        $this->storage->save(new TraceId($id));
    }

    public function get(): TraceId
    {
        return $this->storage->get();
    }

    public function reset(): void
    {
        $this->storage->save(new TraceId($this->generator->v4()));
    }
}

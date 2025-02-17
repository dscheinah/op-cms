<?php

namespace Storage;

use App\Storage\PageStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Data\BackendInterface;

class PageStorageTest extends TestCase
{
    private PageStorage $storage;

    private MockObject $backendMock;

    protected function setUp(): void
    {
        $this->backendMock = $this->createMock(BackendInterface::class);
        $this->storage = new PageStorage(
            $this->backendMock,
        );
    }

    public function testSave(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('INSERT INTO `page` (`type`, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), ['type', 'key', 42, 42]);
        $this->storage->save('type', 'key', 42);
    }

    public function testFetchAll(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT * FROM `page`');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchAll()->current());
    }
}

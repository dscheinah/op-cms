<?php

namespace Storage;

use App\Storage\CalendarStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Data\BackendInterface;

class CalendarStorageTest extends TestCase
{
    private CalendarStorage $storage;

    private MockObject $backendMock;

    protected function setUp(): void
    {
        $this->backendMock = $this->createMock(BackendInterface::class);
        $this->storage = new CalendarStorage(
            $this->backendMock,
        );
    }

    public function testCreate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('INSERT INTO `calendar` (`date`, `time`, `place`, `title`, `description`, `link`) VALUES (?, ?, ?, ?, ?, ?)');
        $this->backendMock->expects($this->once())->method('insert')
            ->with($this->anything(), ['date', 'time', 'place', 'title', 'description', 'link']);
        $this->storage->create('date', 'time', 'place', 'title', 'description', 'link');
    }

    public function testDelete(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('DELETE FROM `calendar` WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), [42]);
        $this->storage->delete(42);
    }

    public function testUpdate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('UPDATE `calendar` SET `date` = ?, `time` = ?, `place` = ?, `title` = ?, `description` = ?, `link` = ? WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), ['date', 'time', 'place', 'title', 'description', 'link', 42]);
        $this->storage->update(42, 'date', 'time', 'place', 'title', 'description', 'link');
    }

    public function testFetchAllFuture(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT * FROM `calendar` WHERE `date` >= DATE(NOW()) ORDER BY `date`, `time`');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchAllFuture()->current());
    }
}

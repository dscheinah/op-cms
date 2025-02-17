<?php

namespace Storage;

use App\Storage\TextStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Data\BackendInterface;

class TextStorageTest extends TestCase
{
    private TextStorage $storage;

    private MockObject $backendMock;

    protected function setUp(): void
    {
        $this->backendMock = $this->createMock(BackendInterface::class);
        $this->storage = new TextStorage(
            $this->backendMock,
        );
    }

    public function testFetchOne(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT * FROM `texts` WHERE `id` = ?');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [42])
            ->willReturnCallback(
                function () {
                    yield ['test'];
                }
            );
        self::assertEquals(['test'], $this->storage->fetchOne(42));
    }

    public function testCreate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('INSERT INTO `texts` (`name`, `content`) VALUES (?, ?)');
        $this->backendMock->expects($this->once())->method('insert')
            ->with($this->anything(), ['name', 'content']);
        $this->storage->create('name', 'content');
    }

    public function testDelete(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('DELETE FROM `texts` WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), [42]);
        $this->storage->delete(42);
    }

    public function testUpdate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('UPDATE `texts` SET `name` = ?, `content` = ? WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), ['name', 'content', 42]);
        $this->storage->update(42, 'name', 'content');
    }

    public function testFetchAll(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT `id`, `name` FROM `texts` ORDER BY `name`');
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

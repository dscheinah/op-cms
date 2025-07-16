<?php

namespace Storage;

use App\Storage\ImageStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Data\BackendInterface;

class ImageStorageTest extends TestCase
{
    private ImageStorage $storage;

    private MockObject $backendMock;

    protected function setUp(): void
    {
        $this->backendMock = $this->createMock(BackendInterface::class);
        $this->storage = new ImageStorage(
            $this->backendMock,
        );
    }

    public function testDelete(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('DELETE FROM `images` WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), [42]);
        $this->storage->delete(42);
    }

    public function testUpdate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('UPDATE `images` SET `name` = ?, `src` = ?, `alt` = ?, `title` = ? WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), ['name', 'src', 'alt', 'title', 42]);
        $this->storage->update(42, 'name', 'src', 'alt', 'title');
    }

    public function testFetchOne(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT * FROM `images` WHERE `id` = ?');
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
            ->with('INSERT INTO `images` (`file`, `name`, `src`, `alt`, `title`) VALUES (?, ?, ?, ?, ?)');
        $this->backendMock->expects($this->once())->method('insert')
            ->with($this->anything(), ['file', 'name', 'src', 'alt', 'title']);
        $this->storage->create('file', 'name', 'src', 'alt', 'title');
    }

    public function testFetchAll(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT `id`, `file`, `name` FROM `images` ORDER BY `name`');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchAll(null)->current());
    }

    public function testFetchAllWithGallery(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with(
                'SELECT `id`, `file`, `name` FROM `images` 
                    INNER JOIN `galleries_x_images` ON `id` = `image_id` 
                    WHERE `gallery_id` = ? 
                    ORDER BY `sort`'
            );
        $this->backendMock->method('fetch')
            ->with($this->anything(), [42])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchAll(42)->current());
    }
}

<?php

namespace Storage;

use App\Storage\GalleryStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Data\BackendInterface;

class GalleryStorageTest extends TestCase
{
    private GalleryStorage $storage;

    private MockObject $backendMock;

    protected function setUp(): void
    {
        $this->backendMock = $this->createMock(BackendInterface::class);
        $this->storage = new GalleryStorage(
            $this->backendMock,
        );
    }

    public function testUpdate(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('UPDATE `galleries` SET `name` = ? WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), ['name', 42]);
        $this->storage->update(42, 'name');
    }

    public function testFetchAll(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT `id`, `name` FROM `galleries` ORDER BY `name`');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchAll()->current());
    }

    public function testDelete(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('DELETE FROM `galleries` WHERE `id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), [42]);
        $this->storage->delete(42);
    }

    public function testFetchOne(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT * FROM `galleries` WHERE `id` = ?');
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
            ->with('INSERT INTO `galleries` (`name`) VALUES (?)');
        $this->backendMock->expects($this->once())->method('insert')
            ->with($this->anything(), ['name']);
        $this->storage->create('name');
    }

    public function testFetchImages(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('SELECT `image_id` FROM `galleries_x_images` WHERE `gallery_id` = ? ORDER BY `sort`');
        $this->backendMock->method('fetch')
            ->with($this->anything(), [42])
            ->willReturnCallback(
                function () {
                    yield 'test';
                }
            );
        self::assertEquals('test', $this->storage->fetchImages(42)->current());
    }

    public function testDeleteImageAssignment(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('DELETE FROM `galleries_x_images` WHERE `gallery_id` = ?');
        $this->backendMock->expects($this->once())->method('execute')
            ->with($this->anything(), [42]);
        $this->storage->deleteImageAssignment(42);
    }

    public function testInsertImageAssignment(): void
    {
        $this->backendMock->expects($this->once())->method('prepare')
            ->with('INSERT INTO `galleries_x_images` (`gallery_id`, `image_id`, `sort`) VALUES (?, ?, ?)');
        $this->backendMock->expects($this->once())->method('insert')
            ->with($this->anything(), [42, 23, 7]);
        $this->storage->insertImageAssignment(42, 23, 7);
    }
}

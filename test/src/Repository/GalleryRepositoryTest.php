<?php

namespace Repository;

use App\Repository\GalleryRepository;
use App\Storage\GalleryStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GalleryRepositoryTest extends TestCase
{
    private GalleryRepository $repository;

    private MockObject $galleryStorageMock;

    protected function setUp(): void
    {
        $this->galleryStorageMock = $this->createMock(GalleryStorage::class);
        $this->repository = new GalleryRepository(
            $this->galleryStorageMock,
        );
    }

    public function testLoad(): void
    {
        $this->galleryStorageMock->method('fetchOne')->with(42)->willReturn(['data']);
        $this->galleryStorageMock->method('fetchImages')->with(42)->willReturnCallback(function () {
            yield ['image_id' => 'one'];
            yield ['image_id' => 'two'];
        });
        self::assertEquals(['data', 'images' => ['one', 'two']], $this->repository->load(42));
    }

    public function testLoadNoId(): void
    {
        $this->galleryStorageMock->expects($this->never())->method('fetchOne');
        self::assertNull($this->repository->load(0));
    }

    public function testLoadNotFound(): void
    {
        $this->galleryStorageMock->method('fetchOne')->with(42)->willReturn(null);
        self::assertNull($this->repository->load(42));
    }

    public function testList(): void
    {
        $this->galleryStorageMock->method('fetchAll')->willReturnCallback(function () {
            yield 'one';
            yield 'two';
        });
        self::assertEquals(['one', 'two'], $this->repository->list());
    }

    public function testSaveInsert(): void
    {
        $this->galleryStorageMock
            ->expects($this->once())
            ->method('create')
            ->with('Name')
            ->willReturn(23);

        $this->galleryStorageMock
            ->expects($this->once())
            ->method('deleteImageAssignment')
            ->with(23);
        $this->galleryStorageMock
            ->expects($this->exactly(2))
            ->method('insertImageAssignment')
            ->with(23, $this->logicalOr(1, 2));

        $this->repository->save(['name' => 'Name', 'images' => [1, 2]]);
    }

    public function testSaveUpdate(): void
    {
        $this->galleryStorageMock->expects($this->once())->method('update')->with(42, 'Name');
        $this->galleryStorageMock->expects($this->once())->method('deleteImageAssignment')->with(42);

        $this->galleryStorageMock
            ->expects($this->exactly(2))
            ->method('insertImageAssignment')
            ->with(42, $this->logicalOr(1, 2));

        $this->repository->save(['id' => 42, 'name' => 'Name', 'images' => [1, 2]]);
    }

    public function testRemove(): void
    {
        $this->galleryStorageMock->expects($this->once())->method('delete')->with(42);
        $this->repository->remove(42);
    }


    public function testRemoveNoId(): void
    {
        $this->galleryStorageMock->expects($this->never())->method('delete');
        $this->repository->remove(0);
    }
}

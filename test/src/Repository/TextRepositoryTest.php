<?php

namespace Repository;

use App\Repository\TextRepository;
use App\Storage\TextStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Collector\Collector;

class TextRepositoryTest extends TestCase
{
    private TextRepository $repository;

    private MockObject $textStorageMock;

    protected function setUp(): void
    {
        $this->textStorageMock = $this->createMock(TextStorage::class);
        $this->collectorMock = $this->createMock(Collector::class);
        $this->repository = new TextRepository(
            $this->textStorageMock,
        );
    }

    public function testSaveInsert(): void
    {
        $this->textStorageMock->expects($this->once())->method('create')->with('Name', 'Content');
        $this->repository->save(['name' => 'Name', 'content' => 'Content']);
    }

    public function testSaveUpdate(): void
    {
        $this->textStorageMock->expects($this->once())->method('update')->with(42, 'Name', 'Content');
        $this->repository->save(['id' => 42, 'name' => 'Name', 'content' => 'Content']);
    }

    public function testList(): void
    {
        $this->textStorageMock->method('fetchAll')->willReturnCallback(function () {
            yield 'one';
            yield 'two';
        });
        self::assertEquals(['one', 'two'], $this->repository->list());
    }

    public function testRemove(): void
    {
        $this->textStorageMock->expects($this->once())->method('delete')->with(42);
        $this->repository->remove(42);
    }

    public function testRemoveNoId(): void
    {
        $this->textStorageMock->expects($this->never())->method('delete');
        $this->repository->remove(0);
    }

    public function testLoad(): void
    {
        $data = ['data'];
        $this->textStorageMock->method('fetchOne')->with(42)->willReturn($data);
        self::assertEquals($data, $this->repository->load(42));
    }

    public function testLoadNoId(): void
    {
        $this->textStorageMock->expects($this->never())->method('fetchOne');
        $this->repository->load(0);
    }
}

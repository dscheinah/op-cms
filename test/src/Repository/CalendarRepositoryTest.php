<?php

namespace Repository;

use App\Repository\CalendarRepository;
use App\Storage\CalendarStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CalendarRepositoryTest extends TestCase
{
    private CalendarRepository $repository;

    private MockObject $calendarStorageMock;

    protected function setUp(): void
    {
        $this->calendarStorageMock = $this->createMock(CalendarStorage::class);
        $this->repository = new CalendarRepository(
            $this->calendarStorageMock,
        );
    }

    public function testSaveInsert(): void
    {
        $this->calendarStorageMock->expects($this->once())->method('create')
            ->with('Date', 'Time', 'Place', 'Title', 'Description', 'Link');
        $this->repository->save(['date' => 'Date', 'time' => 'Time', 'place' => 'Place', 'title' => 'Title', 'description' => 'Description', 'link' => 'Link']);
    }

    public function testSaveInsertMinimal(): void
    {
        $this->calendarStorageMock->expects($this->once())->method('create')
            ->with('Date', null, null, 'Title', null, null);
        $this->repository->save(['date' => 'Date', 'time' => '', 'place' => '', 'title' => 'Title', 'description' => '', 'link' => '']);
    }

    public function testSaveUpdate(): void
    {
        $this->calendarStorageMock->expects($this->once())->method('update')
            ->with(42, 'Date', 'Time', 'Place', 'Title', 'Description', 'Link');
        $this->repository->save(['id' => 42, 'date' => 'Date', 'time' => 'Time', 'place' => 'Place', 'title' => 'Title', 'description' => 'Description', 'link' => 'Link']);
    }

    public function testSaveUpdateMinimal(): void
    {
        $this->calendarStorageMock->expects($this->once())->method('update')
            ->with(42, 'Date', null, null, 'Title', null, null);
        $this->repository->save(['id' => 42, 'date' => 'Date', 'time' => '', 'place' => '', 'title' => 'Title', 'description' => '', 'link' => '']);
    }

    public function testLoad(): void
    {
        $this->calendarStorageMock->method('fetchAllFuture')->willReturnCallback(function () {
            yield 'one';
            yield 'two';
        });
        self::assertEquals(['one', 'two'], $this->repository->load());
    }

    public function testRemove(): void
    {
        $this->calendarStorageMock->expects($this->once())->method('delete')->with(42);
        $this->repository->remove(42);
    }

    public function testRemoveNoId(): void
    {
        $this->calendarStorageMock->expects($this->never())->method('delete');
        $this->repository->remove(0);
    }

}

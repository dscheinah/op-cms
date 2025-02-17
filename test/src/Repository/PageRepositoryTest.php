<?php

namespace Repository;

use App\Repository\PageRepository;
use App\Storage\PageStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorDTO;

class PageRepositoryTest extends TestCase
{
    private const TEMPLATE_FILE = __DIR__ . '/support/template.phtml';

    public static bool $templateTriggered = false;

    private PageRepository $repository;

    private MockObject $pageStorageMock;

    private MockObject $collectorMock;

    protected function setUp(): void
    {
        $this->pageStorageMock = $this->createMock(PageStorage::class);
        $this->collectorMock = $this->createMock(Collector::class);
        $this->repository = new PageRepository(
            $this->pageStorageMock,
            $this->collectorMock,
            self::TEMPLATE_FILE,
        );
        self::$templateTriggered = false;
    }

    public function testCollect(): void
    {
        $this->collectorMock->data = new CollectorDTO();
        $result = $this->repository->collect();
        self::assertSame($this->collectorMock->data, $result);
        self::assertTrue(self::$templateTriggered);
    }

    public function testSave(): void
    {
        $data = [
            'test' => ['x' => 1, 'y' => 2],
            'more' => ['z' => 3],
        ];
        $this->pageStorageMock->expects($this->exactly(3))->method('save')
            ->with(
                $this->logicalOr($this->equalTo('test'), $this->equalTo('more')),
                $this->logicalOr($this->equalTo('x'), $this->equalTo('y'), $this->equalTo('z')),
                $this->logicalOr($this->equalTo(1), $this->equalTo(2), $this->equalTo(3)),
            );
        $this->repository->save($data);
    }
}

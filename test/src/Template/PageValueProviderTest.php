<?php

namespace Template;

use App\Storage\PageStorage;
use App\Template\PageValueProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PageValueProviderTest extends TestCase
{
    private PageValueProvider $pageValueProvider;

    private MockObject $pageStorageMock;

    protected function setUp(): void
    {
        $this->pageStorageMock = $this->createMock(PageStorage::class);
        $this->pageValueProvider = new PageValueProvider(
            $this->pageStorageMock,
        );
    }

    public function testGet(): void
    {
        $this->pageStorageMock->expects($this->once())->method('fetchAll')
            ->willReturnCallback(function () {
                yield ['type' => 'type', 'key' => 'key', 'value' => 23];
                yield ['type' => 'type2', 'key' => 'key2', 'value' => 42];
            });
        self::assertEquals(23, $this->pageValueProvider->get('type', 'key'));
        self::assertEquals(42, $this->pageValueProvider->get('type2', 'key2'));
    }
}

<?php

namespace Template;

use App\Storage\TextStorage;
use App\Template\TextValueProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TextValueProviderTest extends TestCase
{
    private TextValueProvider $textValueProvider;

    private MockObject $textStorageMock;

    protected function setUp(): void
    {
        $this->textStorageMock = $this->createMock(TextStorage::class);
        $this->textValueProvider = new TextValueProvider(
            $this->textStorageMock,
        );
    }

    public function testGet(): void
    {
        $this->textStorageMock->method('fetchOne')->with(42)->willReturn(['content' => 'text']);
        self::assertEquals('text', $this->textValueProvider->get(42));
    }
}

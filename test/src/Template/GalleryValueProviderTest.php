<?php

namespace Template;

use App\Storage\GalleryStorage;
use App\Template\GalleryValueProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GalleryValueProviderTest extends TestCase
{
    private GalleryValueProvider $provider;

    private MockObject $galleryStorageMock;

    protected function setUp(): void
    {
        $this->galleryStorageMock = $this->createMock(GalleryStorage::class);
        $this->provider = new GalleryValueProvider(
            $this->galleryStorageMock,
        );
    }

    public function testGet(): void
    {
        $this->galleryStorageMock
            ->expects($this->once())
            ->method('fetchImages')
            ->with(42)
            ->willReturnCallback(function () {
                yield ['image_id' => 7];
                yield ['image_id' => 13];
            });
        self::assertEquals([7, 13], $this->provider->get(42));
    }

    public function testGetEmpty(): void
    {
        self::assertEquals([], $this->provider->get(42));
    }
}

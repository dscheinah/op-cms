<?php

namespace Template;

use App\Storage\ImageStorage;
use App\Template\ImageValueProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Image\DTO\ImagePropertyDTO;

class ImageValueProviderTest extends TestCase
{
    private const string DIRECTORY = '/dir';

    private ImageValueProvider $provider;

    private MockObject $imageStorageMock;

    protected function setUp(): void
    {
        $this->imageStorageMock = $this->createMock(ImageStorage::class);
        $this->provider = new ImageValueProvider(
            $this->imageStorageMock,
            self::DIRECTORY,
        );
    }

    public function testGet(): void
    {
        $this->imageStorageMock
            ->expects($this->once())
            ->method('fetchOne')
            ->with(42)
            ->willReturn(['file' => 'file', 'src' => 'src', 'title' => 'title', 'alt' => 'alt']);

        $expected = new ImagePropertyDTO();
        $expected->source = self::DIRECTORY . '/file';
        $expected->name = 'src';
        $expected->title = 'title';
        $expected->alt = 'alt';

        self::assertEquals($expected, $this->provider->get('42'));
    }

    public function testGetMinimal(): void
    {
        $this->imageStorageMock->method('fetchOne')->willReturn(['file' => 'file']);

        $expected = new ImagePropertyDTO();
        $expected->source = self::DIRECTORY . '/file';

        self::assertEquals($expected, $this->provider->get(23));
    }

    public function testGetNotFound(): void
    {
        $this->imageStorageMock->method('fetchOne')->willReturn(null);
        self::assertNull($this->provider->get(23));
    }
}

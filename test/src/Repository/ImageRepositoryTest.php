<?php

namespace Repository;

use App\Repository\ImageRepository;
use App\Storage\ImageStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;
use Sx\Image\DTO\RenderedImageDTO;
use Sx\Image\ImageRenderer;
use Sx\Template\Collector\Collector;

class ImageRepositoryTest extends TestCase
{
    private const string DIRECTORY = '/dir';
    private const string CACHE = '/cache';

    private ImageRepository $repository;

    private MockObject $imageStorageMock;

    private MockObject $imageRendererMock;

    protected function setUp(): void
    {
        $this->imageStorageMock = $this->createMock(ImageStorage::class);
        $this->imageRendererMock = $this->createMock(ImageRenderer::class);
        $this->repository = new ImageRepository(
            $this->imageStorageMock,
            $this->imageRendererMock,
            self::DIRECTORY,
            self::CACHE,
        );
    }

    public function testRemove(): void
    {
        $this->imageStorageMock->expects($this->once())->method('delete')->with(42);
        $this->repository->remove(42);
    }


    public function testRemoveNoId(): void
    {
        $this->imageStorageMock->expects($this->never())->method('delete');
        $this->repository->remove(0);
    }

    public function testSaveWithUpload(): void
    {
        $expectedFile = 'upload-name.jpg';

        $uploadMock = $this->createMock(UploadedFileInterface::class);
        $uploadMock->method('getClientFilename')->willReturn('path/to/' . $expectedFile);
        $uploadMock
            ->expects($this->once())
            ->method('moveTo')
            ->with($this->logicalAnd(
                $this->stringStartsWith(self::DIRECTORY . '/'),
                $this->stringEndsWith($expectedFile),
            ));

        $this->imageStorageMock
            ->expects($this->once())
            ->method('create')
            ->with($this->stringEndsWith($expectedFile), 'Name', 'Src', 'Alt', 'Title');

        $this->repository->saveWithUpload(
            ['name' => 'Name', 'src' => 'Src', 'alt' => 'Alt', 'title' => 'Title'],
            $uploadMock
        );
    }

    public function testSaveOnlyData(): void
    {
        $this->imageStorageMock
            ->expects($this->once())
            ->method('update')
            ->with(42, 'Name', 'Src', 'Alt', 'Title');
        $this->repository->saveOnlyData(
            ['id' => '42', 'name' => 'Name', 'src' => 'Src', 'alt' => 'Alt', 'title' => 'Title']
        );
    }

    public function testList(): void
    {
        $this->imageStorageMock->method('fetchAll')->willReturnCallback(function () {
            yield ['one', 'file' => 'load.png'];
            yield ['two', 'file' => 'render.png'];
            yield ['three', 'file' => 'error.png'];
        });

        $this->imageRendererMock
            ->expects($this->exactly(3))
            ->method('readFromJpeg')
            ->willReturnCallback(function ($target) {
                if ($target === self::CACHE . '/load.png-list.jpg') {
                    $imageStub = new RenderedImageDTO();
                    $imageStub->base64 = 'load64';
                    return $imageStub;
                }
                return null;
            });
        $this->imageRendererMock
            ->expects($this->exactly(2))
            ->method('renderToJpeg')
            ->willReturnCallback(function ($source, $target, $width, $height) {
                $matches = $source === self::DIRECTORY . '/render.png'
                    && $target === self::CACHE . '/render.png-list.jpg'
                    && $width === 32
                    && $height === 32;
                if ($matches) {
                    $imageStub = new RenderedImageDTO();
                    $imageStub->base64 = 'render64';
                    return $imageStub;
                }
                return null;
            });


        self::assertEquals(
            [['one', 'base64' => 'load64'], ['two', 'base64' => 'render64'], ['three']],
            $this->repository->list(null)
        );
    }

    public function testListWithGallery(): void
    {
        $this->imageStorageMock->expects($this->once())->method('fetchAll')->with(42);
        self::assertEquals([], $this->repository->list('42'));
    }

    public function testLoad(): void
    {
        $imageStub = new RenderedImageDTO();
        $imageStub->base64 = 'base64';

        $this->imageStorageMock
            ->method('fetchOne')
            ->with(42)
            ->willReturn(['data', 'file' => 'klaus.png']);
        $this->imageRendererMock
            ->expects($this->once())
            ->method('readFromJpeg')
            ->with(self::CACHE . '/klaus.png-load.jpg')
            ->willReturn($imageStub);
        $this->imageRendererMock
            ->expects($this->never())
            ->method('renderToJpeg');

        self::assertEquals(['data', 'base64' => 'base64'], $this->repository->load(42));
    }

    public function testLoadAndRender(): void
    {
        $imageStub = new RenderedImageDTO();
        $imageStub->base64 = 'base64';

        $this->imageStorageMock
            ->method('fetchOne')
            ->with(42)
            ->willReturn(['data', 'file' => 'klaus.png']);
        $this->imageRendererMock
            ->method('readFromJpeg')
            ->with($this->anything())
            ->willReturn(null);
        $this->imageRendererMock
            ->expects($this->once())
            ->method('renderToJpeg')
            ->with(self::DIRECTORY . '/klaus.png', self::CACHE . '/klaus.png-load.jpg', 440, null)
            ->willReturn($imageStub);

        self::assertEquals(['data', 'base64' => 'base64'], $this->repository->load(42));
    }

    public function testLoadRenderError(): void
    {
        $this->imageStorageMock
            ->method('fetchOne')
            ->with(42)
            ->willReturn(['data', 'file' => 'klaus.png']);
        $this->imageRendererMock
            ->method('readFromJpeg')
            ->willReturn(null);
        $this->imageRendererMock
            ->expects($this->once())
            ->method('renderToJpeg')
            ->willReturn(null);

        self::assertEquals(['data'], $this->repository->load(42));
    }

    public function testLoadNoId(): void
    {
        $this->imageStorageMock->expects($this->never())->method('fetchOne');
        self::assertNull($this->repository->load(0));
    }

    public function testLoadNotFound(): void
    {
        $this->imageStorageMock->method('fetchOne')->with(42)->willReturn(null);
        self::assertNull($this->repository->load(42));
    }
}

<?php

namespace Handler;

use App\Handler\ImageSaveHandler;
use App\Repository\ImageRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Sx\Message\Response\ResponseHelperInterface;

class ImageSaveHandlerTest extends TestCase
{
    private ImageSaveHandler $handler;

    private MockObject $helperMock;

    private MockObject $imageRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->imageRepositoryMock = $this->createMock(ImageRepository::class);
        $this->handler = new ImageSaveHandler(
            $this->helperMock,
            $this->imageRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandleOnlyData(): void
    {
        $body = ['id' => 42];
        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->imageRepositoryMock->expects($this->once())->method('saveOnlyData')->with($body);
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }

    public function testHandleWithUpload(): void
    {
        $body = ['body'];
        $upload = $this->createMock(UploadedFileInterface::class);
        $upload->expects($this->once())->method('getError')->willReturn(UPLOAD_ERR_OK);

        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->requestMock->method('getUploadedFiles')->willReturn(['file' => $upload]);

        $this->imageRepositoryMock
            ->expects($this->once())
            ->method('saveWithUpload')
            ->with($body, $upload);

        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);

        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }

    public function testHandleNoUpload(): void
    {
        $body = ['body'];

        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->requestMock->method('getUploadedFiles')->willReturn([]);

        $this->imageRepositoryMock->expects($this->never())->method('saveOnlyData');
        $this->imageRepositoryMock->expects($this->never())->method('saveWithUpload');

        $this->helperMock->method('create')->with(400)->willReturn($this->responseMock);

        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }

    public function testHandleUploadError(): void
    {
        $body = ['body'];
        $upload = $this->createMock(UploadedFileInterface::class);
        $upload->expects($this->once())->method('getError')->willReturn(UPLOAD_ERR_NO_FILE);

        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->requestMock->method('getUploadedFiles')->willReturn(['file' => $upload]);

        $this->imageRepositoryMock->expects($this->never())->method('saveOnlyData');
        $this->imageRepositoryMock->expects($this->never())->method('saveWithUpload');

        $this->helperMock->method('create')->with(400)->willReturn($this->responseMock);

        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}

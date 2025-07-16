<?php

namespace App\Repository;

use App\Storage\ImageStorage;
use Psr\Http\Message\UploadedFileInterface;
use Sx\Image\ImageRenderer;

/**
 * Domain code to handle images.
 */
class ImageRepository
{
    public function __construct(
        private readonly ImageStorage $storage,
        private readonly ImageRenderer $renderer,
        private readonly string $directory,
        private readonly string $cache,
    ) {
    }

    /**
     * Load all images as an array in alphabetical order. The result will contain id and name for each image.
     *
     * To only load images from a gallery, set the id with the according parameter.
     *
     * @param int|null $gallery
     *
     * @return array
     */
    public function list(?int $gallery): array
    {
        $images = [];
        foreach ($this->storage->fetchAll($gallery) as $image) {
            $target = $this->cache . '/' . $image['file'] . '-list.jpg';
            $rendered = $this->renderer->readFromJpeg($target)
                ?: $this->renderer->renderToJpeg($this->directory . '/' . $image['file'], $target, 32, 32);
            if ($rendered) {
                $image['base64'] = $rendered->base64;
            }
            unset($image['file']);
            $images[] = $image;
        }
        return $images;
    }

    /**
     * Load one image given by id or null if not found. The result will contain id, all properties and the base64 image.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function load(int $id): ?array
    {
        if (!$id) {
            return null;
        }
        $image = $this->storage->fetchOne($id);
        if (!$image) {
            return null;
        }
        $target = $this->cache . '/' . $image['file'] . '-load.jpg';
        $rendered = $this->renderer->readFromJpeg($target)
            ?: $this->renderer->renderToJpeg($this->directory . '/' . $image['file'], $target, 440);
        if ($rendered) {
            $image['base64'] = $rendered->base64;
        }
        unset($image['file']);
        return $image;
    }

    /**
     * Inserts image data and stores the file for new images. If an id is present, updates an existing image.
     *
     * @param array $data
     *
     * @return void
     */
    public function saveOnlyData(array $data): void
    {
        $this->storage->update((int) $data['id'], $data['name'], $data['src'], $data['alt'], $data['title']);
    }

    /**
     * Inserts image data and stores the file for new images. If an id is present, updates an existing image.
     *
     * @param array $data
     * @param UploadedFileInterface $upload
     *
     * @return void
     */
    public function saveWithUpload(array $data, UploadedFileInterface $upload): void
    {
        $file = uniqid('', false) . '-' . basename($upload->getClientFilename());
        $upload->moveTo($this->directory . '/' . $file);
        $this->storage->create($file, $data['name'], $data['src'], $data['alt'], $data['title']);
    }

    /**
     * Delete the image by id.
     *
     * @param int $id
     *
     * @return void
     */
    public function remove(int $id): void
    {
        if (!$id) {
            return;
        }
        $this->storage->delete($id);
    }
}

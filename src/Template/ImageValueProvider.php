<?php

namespace App\Template;

use App\Storage\ImageStorage;
use Sx\Template\Image\DTO\ImagePropertyDTO;
use Sx\Template\Image\ImageValueProviderInterface;

class ImageValueProvider implements ImageValueProviderInterface
{
    public function __construct(
        private readonly ImageStorage $storage,
        private readonly string $directory,
    ) {
    }

    /**
     * Return the image to render from the database for one selected image.
     *
     * @param mixed $value
     *
     * @return ImagePropertyDTO|null
     */
    public function get(mixed $value): ?ImagePropertyDTO
    {
        $image = $this->storage->fetchOne((int) $value);
        if (!$image) {
            return null;
        }
        $properties = new ImagePropertyDTO();
        $properties->source = $this->directory . '/' . $image['file'];
        $properties->name = $image['src'] ?? null;
        $properties->title = $image['title'] ?? null;
        $properties->alt = $image['alt'] ?? null;
        return $properties;
    }
}

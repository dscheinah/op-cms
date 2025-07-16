<?php

namespace App\Template;

use App\Storage\GalleryStorage;
use Sx\Template\Image\GalleryValueProviderInterface;

class GalleryValueProvider implements GalleryValueProviderInterface
{
    public function __construct(
        private readonly GalleryStorage $storage,
    ) {
    }

    /**
     * Return the images to render from the database for one selected gallery.
     *
     * @param mixed $value
     *
     * @return iterable<mixed>
     */
    public function get(mixed $value): iterable
    {
        return array_column(iterator_to_array($this->storage->fetchImages((int) $value)), 'image_id');
    }
}

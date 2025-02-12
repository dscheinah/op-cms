<?php

namespace App\Repository;

use App\Storage\PageStorage;
use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorDTO;

class PageRepository
{
    public function __construct(
        private readonly PageStorage $storage,
        private readonly Collector $collector,
        private readonly string $templateFile,
    ) {
    }

    public function collect(): CollectorDTO
    {
        ob_start();
        include $this->templateFile;
        ob_end_clean();
        return $this->collector->data;
    }

    public function save(array $param): void
    {
        foreach ($param as $type => $entry) {
            foreach ($entry as $key => $value) {
                $this->storage->save($type, $key, $value);
            }
        }
    }
}

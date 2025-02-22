<?php

namespace App\Repository;

use App\Storage\PageStorage;
use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorDTO;

/**
 * Domain code to handle page data.
 */
class PageRepository
{
    public function __construct(
        private readonly PageStorage $storage,
        private readonly Collector $collector,
        private readonly string $templateFile,
    ) {
    }

    /**
     * Collects all information from the template needed to provide the selections.
     * This also contains all currently selected values from the database.
     *
     * See the return DTO to see the result's structure.
     *
     * @return CollectorDTO
     */
    public function collect(): CollectorDTO
    {
        // Do not render the template.
        ob_start();
        include $this->templateFile;
        ob_end_clean();
        // The registered Template-implementations pushed all relevant data to the collector within the `include`.
        return $this->collector->data;
    }

    /**
     * Saves all selected values. The array is expected to be of the form [type => [key => value]].
     *
     * @param array $param
     *
     * @return void
     */
    public function save(array $param): void
    {
        foreach ($param as $type => $entry) {
            foreach ($entry as $key => $value) {
                $this->storage->save($type, $key, $value);
            }
        }
    }
}

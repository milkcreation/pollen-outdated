<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser\Adapters;

use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\OutdatedBrowserAwareTrait;

abstract class AbstractOutdatedBrowserAdapter implements AdapterInterface
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser)
    {
        $this->setOutdatedBrowser($outdatedBrowser);
    }
}
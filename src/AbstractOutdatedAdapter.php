<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Support\Concerns\BootableTrait;

abstract class AbstractOutdatedAdapter implements OutdatedAdapterInterface
{
    use BootableTrait;
    use OutdatedProxy;

    /**
     * @param OutdatedInterface $outdated
     */
    public function __construct(OutdatedInterface $outdated)
    {
        $this->setOutdated($outdated);

        $this->boot();
    }

    /**
     * @inheritDoc
     */
    abstract public function boot(): void;
}
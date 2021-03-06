<?php

declare(strict_types=1);

namespace Pollen\Outdated;

abstract class AbstractOutdatedAdapter implements OutdatedAdapterInterface
{
    use OutdatedProxy;

    /**
     * @param OutdatedInterface $outdated
     */
    public function __construct(OutdatedInterface $outdated)
    {
        $this->setOutdated($outdated);
    }
}
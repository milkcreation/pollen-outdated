<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Support\Concerns\BootableTraitInterface;

interface OutdatedAdapterInterface extends BootableTraitInterface, OutdatedProxyInterface
{
    /**
     * Chargement.
     *
     * @return void
     */
    public function boot(): void;
}
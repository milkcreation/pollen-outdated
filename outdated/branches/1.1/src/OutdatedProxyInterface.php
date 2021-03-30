<?php

declare(strict_types=1);

namespace Pollen\Outdated;

interface OutdatedProxyInterface
{
    /**
     * Instance du gestionnaire de navigateur déprécié.
     *
     * @return OutdatedInterface
     */
    public function outdated(): OutdatedInterface;

    /**
     * Définition du gestionnaire de navigateur déprécié.
     *
     * @param OutdatedInterface $outdated
     *
     * @return void
     */
    public function setOutdated(OutdatedInterface $outdated): void;
}
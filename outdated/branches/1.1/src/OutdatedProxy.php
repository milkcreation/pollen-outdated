<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Support\ProxyResolver;
use RuntimeException;

trait OutdatedProxy
{
    /**
     * Instance du gestionnaire de navigateur déprécié.
     * @var OutdatedInterface
     */
    private $outdated;

    /**
     * Instance du gestionnaire de navigateur déprécié.
     *
     * @return OutdatedInterface
     */
    public function outdated(): OutdatedInterface
    {
        if ($this->outdated === null) {
            try {
                $this->outdated = Outdated::getInstance();
            } catch (RuntimeException $e) {
                $this->outdated = ProxyResolver::getInstance(
                    OutdatedInterface::class,
                    Outdated::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        return $this->outdated;
    }

    /**
     * Définition du gestionnaire de navigateur déprécié.
     *
     * @param OutdatedInterface $outdated
     *
     * @return void
     */
    public function setOutdated(OutdatedInterface $outdated): void
    {
        $this->outdated = $outdated;
    }
}
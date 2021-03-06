<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Psr\Container\ContainerInterface as Container;
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
            $container = method_exists($this, 'getContainer') ? $this->getContainer() : null;

            if ($container instanceof Container && $container->has(OutdatedInterface::class)) {
                $this->outdated = $container->get(OutdatedInterface::class);
            } else {
                try {
                    $this->outdated = Outdated::getInstance();
                } catch (RuntimeException $e) {
                    $this->outdated = new Outdated();
                }
            }
        }

        return $this->outdated;
    }

    /**
     * Définition du gestionnaire de navigateur déprécié.
     *
     * @param OutdatedInterface $outdated
     *
     * @return static
     */
    public function setOutdated(OutdatedInterface $outdated): self
    {
        $this->outdated = $outdated;

        return $this;
    }
}
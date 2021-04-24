<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Concerns\ResourcesAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\PartialProxyInterface;

interface OutdatedInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ResourcesAwareTraitInterface,
    ContainerProxyInterface,
    PartialProxyInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): OutdatedInterface;

    /**
     * Récupération de l'instance de l'adapteur.
     *
     * @return OutdatedAdapterInterface|null
     */
    public function getAdapter(): ?OutdatedAdapterInterface;

    /**
     * Récupération du rendu HTML.
     *
     * @return string
     */
    public function getHtmlRender(): string;

    /**
     * Récupération des styles CSS.
     *
     * @return string
     */
    public function getStyles(): string;

    /**
     * Récupération des scripts JS.
     *
     * @return string
     */
    public function getScripts(): string;

    /**
     * Définition de l'adapteur associé.
     *
     * @param OutdatedAdapterInterface $adapter
     *
     * @return static
     */
    public function setAdapter(OutdatedAdapterInterface $adapter): OutdatedInterface;
}
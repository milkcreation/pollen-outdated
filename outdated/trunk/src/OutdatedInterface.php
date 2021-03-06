<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\PartialProxyInterface;

interface OutdatedInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    PartialProxyInterface
{
    /**
     * Résolution de sortie le classe sous forme de chaîne de caractères.
     *
     * @return string
     */
    public function __toString(): string;

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
     * Chemin absolu vers une ressource (fichier|répertoire).
     *
     * @param string|null $path Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function resources(?string $path = null): string;

    /**
     * Définition du chemin absolu vers le répertoire des ressources.
     *
     * @param string $resourceBaseDir
     *
     * @return static
     */
    public function setResourcesBaseDir(string $resourceBaseDir): OutdatedInterface;

    /**
     * Définition de l'adapteur associé.
     *
     * @param OutdatedAdapterInterface $adapter
     *
     * @return static
     */
    public function setAdapter(OutdatedAdapterInterface $adapter): OutdatedInterface;
}
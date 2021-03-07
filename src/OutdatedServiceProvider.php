<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Container\BaseServiceProvider;
use Pollen\Partial\PartialManagerInterface;
use Pollen\Outdated\Adapters\WpOutdatedAdapter;
use Pollen\Outdated\Partial\OutdatedPartial;


class OutdatedServiceProvider extends BaseServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        OutdatedInterface::class,
        OutdatedPartial::class,
        WpOutdatedAdapter::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(
            OutdatedInterface::class,
            function () {
                return new Outdated([], $this->getContainer());
            }
        );

        $this->registerAdapters();
        $this->registerPartials();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(
            WpOutdatedAdapter::class,
            function () {
                return new WpOutdatedAdapter($this->getContainer()->get(OutdatedInterface::class));
            }
        );
    }

    /**
     * Déclaration des pilote de portion d'affichage.
     *
     * @return void
     */
    public function registerPartials(): void
    {
        $this->getContainer()->add(
            OutdatedPartial::class,
            function () {
                return new OutdatedPartial(
                    $this->getContainer()->get(OutdatedInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
    }
}
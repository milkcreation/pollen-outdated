<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser;

use tiFy\Contracts\Partial\Partial as PartialManagerContract;
use Pollen\OutdatedBrowser\Adapters\WordpressAdapter;
use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Container\ServiceProvider;

class OutdatedBrowserServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        OutdatedBrowserContract::class,
        OutdatedBrowserPartial::class,
        WordpressAdapter::class,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            /** @var OutdatedBrowserContract $obrowser */
            $obrowser = $this->getContainer()->get(OutdatedBrowserContract::class);

            $obrowser->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(OutdatedBrowserContract::class, function (): OutdatedBrowserContract {
            return new OutdatedBrowser(config('outdated-browser', []), $this->getContainer());
        });

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
        $this->getContainer()->share(WordpressAdapter::class, function () {
            return new WordpressAdapter($this->getContainer()->get(OutdatedBrowserContract::class));
        });
    }

    /**
     * Déclaration des pilote de portion d'affichage.
     *
     * @return void
     */
    public function registerPartials(): void
    {
        $this->getContainer()->add(OutdatedBrowserPartial::class, function () {
            return new OutdatedBrowserPartial(
                $this->getContainer()->get(OutdatedBrowserContract::class),
                $this->getContainer()->get(PartialManagerContract::class)
            );
        });
    }
}
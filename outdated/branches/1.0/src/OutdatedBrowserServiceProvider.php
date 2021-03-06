<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser;

use Pollen\OutdatedBrowser\Adapters\WordpressAdapter;
use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Container\ServiceProvider;
use tiFy\Partial\Contracts\PartialContract;

class OutdatedBrowserServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
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
            /** @var OutdatedBrowserContract $outdatedBrowser */
            $outdatedBrowser = $this->getContainer()->get(OutdatedBrowserContract::class);

            $outdatedBrowser->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
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
        $this->registerPartialDrivers();
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
    public function registerPartialDrivers(): void
    {
        $this->getContainer()->add(OutdatedBrowserPartial::class, function () {
            return new OutdatedBrowserPartial(
                $this->getContainer()->get(OutdatedBrowserContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });
    }
}
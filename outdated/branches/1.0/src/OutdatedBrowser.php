<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser;

use RuntimeException;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Partial\Partial;
use Pollen\OutdatedBrowser\Adapters\AdapterInterface;
use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\Partial\OutdatedBrowserPartial;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\Concerns\PartialManagerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class OutdatedBrowser implements OutdatedBrowserContract
{
    use BootableTrait;
    use ContainerAwareTrait;
    use PartialManagerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Instance de l'adapteur associé.
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    private $configBag;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [];

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): OutdatedBrowserContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->partialManager()->get('outdated-browser', ['lowerThan' => $this->config('lowerThan', 'borderImage')])->render();
    }

    /**
     * @inheritDoc
     */
    public function boot(): OutdatedBrowserContract
    {
        if (!$this->isBooted()) {
            events()->trigger('outdated-browser.booting', [$this]);

            $this->partialManager()->register(
                'outdated-browser',
                $this->containerHas(OutdatedBrowserPartial::class)
                    ? $this->containerGet(OutdatedBrowserPartial::class)
                    : (new OutdatedBrowserPartial($this, $this->partialManager()))
            );

            $this->setBooted();

            events()->trigger('outdated-browser.booted', [$this]);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->configBag) || is_null($this->configBag)) {
            $this->configBag = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->configBag->get($key, $default);
        } elseif (is_array($key)) {
            return $this->configBag->set($key);
        } else {
            return $this->configBag;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAdapter(): ?AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @inheritDoc
     */
    public function getProvider(string $name)
    {
        return $this->config("providers.{$name}", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) ||is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
        }
        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setAdapter(AdapterInterface $adapter): OutdatedBrowserContract
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): OutdatedBrowserContract
    {
        $this->config($attrs);

        return $this;
    }
}

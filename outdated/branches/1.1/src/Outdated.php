<?php

declare(strict_types=1);

namespace Pollen\Outdated;

use Pollen\Outdated\Adapters\WpOutdatedAdapter;
use Pollen\Outdated\Partial\OutdatedPartial;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Filesystem;
use Pollen\Support\Proxy\ContainerProxy;
use Pollen\Support\Proxy\PartialProxy;
use RuntimeException;
use Psr\Container\ContainerInterface as Container;

class Outdated implements OutdatedInterface
{
    use BootableTrait;
    use ConfigBagAwareTrait;
    use ContainerProxy;
    use PartialProxy;

    /**
     * Instance principale.
     * @var static|null
     */
    private static $instance;

    /**
     * Instance de l'adapteur associé.
     * @var OutdatedAdapterInterface
     */
    private $adapter;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [];

    /**
     * Chemin vers le répertoire des ressources.
     * @var string|null
     */
    protected $resourcesBaseDir;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], ?Container $container = null)
    {
        $this->setConfig($config);

        if ($container !== null) {
            $this->setContainer($container);
        }

        if ($this->config('boot_enabled', true)) {
            $this->boot();
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * Récupération de l'instance principale.
     *
     * @return static
     */
    public static function getInstance(): OutdatedInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): OutdatedInterface
    {
        if (!$this->isBooted()) {
            if ($this->adapter === null && defined('WPINC')) {
                $this->setAdapter(new WpOutdatedAdapter($this));
            }

            $this->partial()->register(
                'outdated',
                $this->containerHas(OutdatedPartial::class)
                    ? OutdatedPartial::class
                    : new OutdatedPartial($this, $this->partial())
            );

            $this->setBooted();
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAdapter(): ?OutdatedAdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @inheritDoc
     */
    public function getHtmlRender(): string
    {
        return $this->partial()->get('outdated')->render();
    }

    /**
     * @inheritDoc
     */
    public function getStyles(): string
    {
        $concatCss = '';

        if (file_exists($this->resources('/assets/dist/partial/outdated.min.css'))) {
            $concatCss .= file_get_contents($this->resources('/assets/dist/partial/outdated.min.css'));
        }

        return "<style type=\"text/css\">{$concatCss}</style>";
    }

    /**
     * @inheritDoc
     */
    public function getScripts(): string
    {
        $concatJs = '';

        if (file_exists($this->resources('/assets/dist/partial/outdated.min.js'))) {
            $concatJs .= file_get_contents($this->resources('/assets/dist/partial/outdated.min.js'));
        }

        $lowerThan = $this->config('lowerThan', 'Edge');

        $concatJs .= "window.addEventListener('DOMContentLoaded', () => {Outdated('{$lowerThan}')})";

        return "<script type=\"text/javascript\">/* <![CDATA[ */{$concatJs}/* ]]> */</script>";
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null): string
    {
        if ($this->resourcesBaseDir === null) {
            $this->resourcesBaseDir = Filesystem::normalizePath(
                realpath(
                    dirname(__DIR__) . '/resources/'
                )
            );

            if (!file_exists($this->resourcesBaseDir)) {
                throw new RuntimeException('Outdated ressources directory unreachable');
            }
        }

        return is_null($path) ? $this->resourcesBaseDir : $this->resourcesBaseDir . Filesystem::normalizePath($path);
    }

    /**
     * @inheritDoc
     */
    public function setResourcesBaseDir(string $resourceBaseDir): OutdatedInterface
    {
        $this->resourcesBaseDir = Filesystem::normalizePath($resourceBaseDir);

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function setAdapter(OutdatedAdapterInterface $adapter): OutdatedInterface
    {
        $this->adapter = $adapter;

        return $this;
    }
}

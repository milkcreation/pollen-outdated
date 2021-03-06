<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser\Partial;

use tiFy\Contracts\Partial\Partial as PartialManager;
use tiFy\Partial\PartialDriver;
use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\OutdatedBrowserAwareTrait;

class OutdatedBrowserPartial extends PartialDriver
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     * @param PartialManager $partialManager
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser, PartialManager $partialManager)
    {
        $this->setOutdatedBrowser($outdatedBrowser);

        parent::__construct($partialManager);
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'bgColor'               => '#F25648',
            'color'                 => '#FFF',
            'lowerThan'             => 'borderImage'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        /*add_action('init', function () {
            $this->attributes = array_merge($this->attributes, config('outdated-browser', []));

            Asset::setDataJs('outdatedBrowser', [
                'bgColor'      => $this->get('bgColor'),
                'color'        => $this->get('color'),
                'lowerThan'    => $this->get('lowerThan'),
                'languagePath' => $this->get('languagePath'),
            ], true);
        });*/

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->outdatedBrowser()->resources('views/partial/outdated-browser');
    }
}
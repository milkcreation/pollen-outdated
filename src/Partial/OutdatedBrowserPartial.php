<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser\Partial;

use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;
use Pollen\OutdatedBrowser\OutdatedBrowserAwareTrait;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Partial\PartialDriver;

class OutdatedBrowserPartial extends PartialDriver
{
    use OutdatedBrowserAwareTrait;

    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     * @param PartialContract $partialManager
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser, PartialContract $partialManager)
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
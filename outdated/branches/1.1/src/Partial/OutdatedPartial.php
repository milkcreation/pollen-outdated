<?php

declare(strict_types=1);

namespace Pollen\Outdated\Partial;

use Pollen\Outdated\OutdatedInterface;
use Pollen\Outdated\OutdatedProxy;
use Pollen\Partial\PartialDriverInterface;
use Pollen\Partial\PartialManagerInterface;
use Pollen\Partial\PartialDriver;

class OutdatedPartial extends PartialDriver
{
    use OutdatedProxy;

    /**
     * @param OutdatedInterface $outdated
     * @param PartialManagerInterface $partialManager
     */
    public function __construct(OutdatedInterface $outdated, PartialManagerInterface $partialManager)
    {
        $this->setOutdated($outdated);

        parent::__construct($partialManager);
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'lowerThan' => 'Edge',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function parseAttrId(): PartialDriverInterface
    {
        if (!$this->has('attrs.id')) {
            $this->set('attrs.id', 'outdated');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->outdated()->resources('/views/partial/outdated');
    }
}
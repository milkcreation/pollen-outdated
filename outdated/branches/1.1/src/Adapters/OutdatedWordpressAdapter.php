<?php

declare(strict_types=1);

namespace Pollen\Outdated\Adapters;

use Pollen\Outdated\OutdatedInterface;
use Pollen\Outdated\AbstractOutdatedAdapter;

class OutdatedWordpressAdapter extends AbstractOutdatedAdapter
{
    /**
     * @param OutdatedInterface $outdated
     */
    public function __construct(OutdatedInterface $outdated)
    {
        parent::__construct($outdated);

        if ($this->outdated()->config('wordpress.autoload', true) === true) {
            add_action(
                'wp_head',
                function () {
                    echo $this->outdated()->getStyles();
                }
            );
            add_action(
                'wp_footer',
                function () {
                    echo $this->outdated()->getHtmlRender();
                    echo $this->outdated()->getScripts();
                }
            );
        }
    }
}
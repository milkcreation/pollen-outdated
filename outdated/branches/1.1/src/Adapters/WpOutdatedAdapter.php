<?php

declare(strict_types=1);

namespace Pollen\Outdated\Adapters;

use Pollen\Outdated\AbstractOutdatedAdapter;

class WpOutdatedAdapter extends AbstractOutdatedAdapter
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (!$this->isBooted()) {
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

            $this->setBooted();
        }
    }
}
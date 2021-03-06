<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser\Adapters;

use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;

class WordpressAdapter extends AbstractOutdatedBrowserAdapter
{
    /**
     * @param OutdatedBrowserContract $outdatedBrowser
     */
    public function __construct(OutdatedBrowserContract $outdatedBrowser)
    {
        parent::__construct($outdatedBrowser);

        if ($this->outdatedBrowser()->config('wordpress.autoload', true) === true) {
            add_action('wp_footer', function () {
                echo $this->outdatedBrowser();
            }, 999999);
        }
    }
}
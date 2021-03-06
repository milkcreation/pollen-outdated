<?php declare(strict_types=1);

namespace Pollen\OutdatedBrowser;

use Exception;
use Pollen\OutdatedBrowser\Contracts\OutdatedBrowserContract;

trait OutdatedBrowserAwareTrait
{
    /**
     * Instance du gestionnaire.
     * @var OutdatedBrowserContract|null
     */
    private $outdatedBrowser;

    /**
     * Récupération de l'instance du gestionnaire.
     *
     * @return OutdatedBrowserContract|null
     */
    public function outdatedBrowser(): ?OutdatedBrowserContract
    {
        if (is_null($this->outdatedBrowser)) {
            try {
                $this->outdatedBrowser = OutdatedBrowser::instance();
            } catch (Exception $e) {
                $this->outdatedBrowser;
            }
        }
        return $this->outdatedBrowser;
    }

    /**
     * Définition de l'instance du gestionnaire.
     *
     * @param OutdatedBrowserContract $outdatedBrowser
     *
     * @return static
     */
    public function setOutdatedBrowser(OutdatedBrowserContract $outdatedBrowser): self
    {
        $this->outdatedBrowser = $outdatedBrowser;

        return $this;
    }
}
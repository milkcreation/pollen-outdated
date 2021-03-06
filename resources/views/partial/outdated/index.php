<?php
/**
 * @var Pollen\Partial\PartialViewLoaderInterface $this
 */
?>
<div <?php echo $this->htmlAttrs(); ?>>
    <div class="Outdated-title"><?php _e('La version de votre navigateur est obsolète.', 'tify'); ?></div>

    <p class="Outdated-text">
        <?php _e('Vous ne pourrez pas afficher de manière optimale le contenu de ce site.', 'tify'); ?>
        <a class="Outdated-upload" href="http://outdatedbrowser.com/fr" target="_blank" rel="noreferrer">
            <?php _e('Télécharger', 'tify'); ?>
        </a>
    </p>

    <button aria-label="<?php __('Fermer', 'tify'); ?>" id="outdated--close" class="Outdated-close">&times;</button>
</div>
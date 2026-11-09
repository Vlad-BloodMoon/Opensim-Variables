<?php
require_once __DIR__.'/inc/site.php';
begin_page('OpenSimulator Handbook','OpenSimulator Handbook','Retrouve tous les guides organisés par thème, sans perdre aucune sous-page.','Find every guide organized by category, with every subpage accessible.');
$groups=handbook_groups();
?>
<div class="home-intro"><p><?php echo e(t('Choisis un thème ou utilise le sommaire dépliable à gauche. Toutes les pages de chaque rubrique sont listées ci-dessous.','Choose a topic or use the collapsible sidebar. Every guide is listed below.')); ?></p><p class="home-count"><?php echo count($groups).' '.e(t('rubriques','categories')).' · '.array_sum(array_map(static fn($group)=>count($group[3]),$groups)).' '.e(t('guides','guides')); ?></p></div>
<nav class="home-jump" aria-label="<?php echo e(t('Accès direct aux rubriques','Jump to categories')); ?>">
<?php foreach($groups as $g): ?><a href="#group-<?php echo e($g[0]); ?>"><?php echo e(t($g[1],$g[2])); ?></a><?php endforeach; ?>
</nav>
<div class="home-categories">
<?php foreach($groups as $g): ?>
<section id="group-<?php echo e($g[0]); ?>" class="home-category">
<header class="home-category-header"><h2><?php echo e(t($g[1],$g[2])); ?></h2><small><?php echo count($g[3]).' '.e(t('guides','guides')); ?></small></header>
<div class="home-page-grid">
<?php foreach($g[3] as $entry): ?>
<a href="<?php echo e($entry[0]); ?>.php?lang=<?php echo e($lang); ?>"><span><?php echo e(t($entry[1],$entry[2])); ?></span><span aria-hidden="true">›</span></a>
<?php endforeach; ?>
</div>
</section>
<?php endforeach; ?>
</div>
<?php end_page(); ?>

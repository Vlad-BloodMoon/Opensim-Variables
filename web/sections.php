<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/site.php';
$catalog = __DIR__ . '/INI.CSV';
$sections = [];
$error = null;
if (!is_readable($catalog)) {
    $error = t("Le fichier INI.CSV est absent. Copiez-le à côté de sections.php.", "INI.CSV is missing. Copy it next to sections.php.");
} elseif (($handle = fopen($catalog, 'rb')) !== false) {
    $header = fgetcsv($handle, 0, ',', '"', '');
    if (is_array($header)) {
        $header = array_map(static fn($x) => preg_replace('/^\xEF\xBB\xBF/', '', (string)$x), $header);
        while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
            if (count($row) !== count($header)) continue;
            $record = array_combine($header, $row);
            $section = trim($record['Section'] ?? '');
            if ($section === '') continue;
            if (!isset($sections[$section])) $sections[$section] = [];
            $sections[$section][] = $record;
        }
    }
    fclose($handle);
    ksort($sections, SORT_NATURAL | SORT_FLAG_CASE);
}
$active = trim((string)($_GET['section'] ?? ''));
if (strlen($active) > 150 || !array_key_exists($active, $sections)) $active = '';
$descriptions = [
 'Startup'=>['Démarrage du simulateur et options générales, notamment console, journalisation, modules et moteur physique.','Simulator startup and global options, including console, logging, modules and physics.'],
 'Const'=>['Constantes réutilisables par les autres sections, notamment URL, noms de domaine et ports.','Reusable constants referenced by other sections, including URLs, hosts and ports.'],
 'Network'=>['Paramètres réseau du simulateur : adresses, ports et communications.','Simulator network settings: addresses, ports and communication.'],
 'OSSL'=>['Permissions et paramètres liés aux fonctions OpenSimulator Scripting Language.','Permissions and configuration for OpenSimulator Scripting Language functions.'],
 'YEngine'=>['Paramètres du moteur de scripts YEngine.','YEngine scripting engine configuration.'],
 'BulletSim'=>['Réglages du moteur physique BulletSim : à modifier avec des tests de collision et de charge.','BulletSim physics engine parameters: tune with collision and load tests.'],
 'ODEPhysicsSettings'=>['Paramètres de physique ODE : le comportement dépend du moteur et de la version.','ODE physics settings: behavior varies by engine and version.'],
 'LoginService'=>['Comportement du service de connexion des avatars.','Avatar login service behavior.'],
 'GridService'=>['Gestion des régions et de leur référencement par les services de grille.','Region registration and lookup through grid services.'],
 'Groups'=>['Services et paramètres des groupes.','Group services and settings.'],
 'Economy'=>['Configuration des services économiques et modules de monnaie.','Economy services and currency module configuration.'],
 'Modules'=>['Activation et sélection de modules complémentaires du simulateur.','Enabling and selecting simulator modules.'],
 'GridInfo'=>['Informations affichées aux clients et visualiseurs sur la grille.','Grid information exposed to clients and viewers.'],
 'Map'=>['Fonctionnement des cartes et services de carte.','Map handling and map services.'],
];
begin_page('Explorer les sections INI','Browse INI sections',
'Recherche dédiée par section, sommaire alphabétique et paramètres détaillés issus du catalogue.',
'Dedicated section search, alphabetical index and detailed settings from the catalog.');
if ($error !== null) {
    echo '<div class="callout">'.e($error).'</div>';
} else {
    echo '<div class="callout">'.e(t('Les sections proviennent du catalogue INI.CSV. Certaines sont dynamiques, inférées ou propres à des modules facultatifs. Elles ne correspondent pas toutes à une section à ajouter dans OpenSim.ini.', 'Sections come from INI.CSV. Some are dynamic, inferred, or specific to optional modules. Not every entry belongs in OpenSim.ini.')).'</div>';
    if ($active !== '') {
        $rows = $sections[$active];
        echo '<p><a href="sections.php?lang='.e($lang).'">'.e(t('← Revenir à toutes les sections','← Back to all sections')).'</a></p>';
        echo '<h2 id="section-title">['.e($active).'] <small>('.count($rows).' '.e(t('paramètres','settings')).')</small></h2>';
        if (isset($descriptions[$active])) echo '<p>'.e(t($descriptions[$active][0],$descriptions[$active][1])).'</p>';
        else echo '<p>'.e(t('Les paramètres ci-dessous sont recensés dans le catalogue. Leur disponibilité dépend de la version d’OpenSimulator et des modules installés.', 'The settings below are listed in the catalog. Availability depends on OpenSimulator version and installed modules.')).'</p>';
        echo '<div class="searchbar"><input type="search" id="settingQuery" placeholder="'.e(t('Filtrer les paramètres de cette section…','Filter settings in this section…')).'" aria-label="'.e(t('Filtrer les paramètres','Filter settings')).'"></div>';
        echo '<p id="settingCount">'.count($rows).' '.e(t('paramètres','settings')).'</p><div id="settingList">';
        foreach ($rows as $item) {
            $name = $item['Name'] ?? '';
            echo '<details class="record setting-row"><summary><code>'.e($name).'</code> <small>'.e($item['Type'] ?? '').'</small></summary>';
            echo '<p><strong>'.e(t('Valeur du catalogue','Catalog value')).' :</strong> <code>'.e($item['Value'] ?? '').'</code></p>';
            echo '<p><strong>'.e(t('Description technique (source anglaise)','Technical description (original English')).' :</strong> '.e($item['Description'] ?? '').'</p>';
            echo '<p><strong>'.e(t('Emplacement dans le code','Source code')).' :</strong> <small>'.e($item['SourceFiles'] ?? '').'</small></p>';
            echo '<p><strong>'.e(t('Référence INI','INI reference')).' :</strong> <small>'.e($item['IniFiles'] ?? '').'</small></p></details>';
        }
        echo '</div>';
    } else {
        echo '<h2>'.e(t('Toutes les sections par ordre alphabétique','All sections A–Z')).'</h2>';
        echo '<div class="searchbar"><input id="sectionSearch" type="search" autofocus placeholder="'.e(t('Ex. Startup, Network, OSSL, Physics…','e.g. Startup, Network, OSSL, Physics…')).'" aria-label="'.e(t('Chercher une section','Search sections')).'"><button class="copy" type="button" id="clearSectionSearch">'.e(t('Effacer','Clear')).'</button></div>';
        echo '<p id="sectionCount">'.count($sections).' '.e(t('sections recensées','catalogued sections')).'</p>';
        echo '<div class="section-grid" id="sectionGrid">';
        foreach ($sections as $section => $rows) {
            $desc = isset($descriptions[$section]) ? t($descriptions[$section][0],$descriptions[$section][1]) : t('Parcourir les paramètres de cette section','Browse settings in this section');
            $url = 'sections.php?lang='.rawurlencode($lang).'&section='.rawurlencode($section);
            echo '<a class="section-tile" data-name="'.e(mb_strtolower($section,'UTF-8')).'" href="'.e($url).'"><strong>['.e($section).']</strong><small>'.count($rows).' '.e(t('paramètres','settings')).'</small><span>'.e($desc).'</span></a>';
        }
        echo '</div>';
    }
}
end_page();
?>
<script>
(() => {
 const search = document.getElementById('sectionSearch');
 if (search) {
   const items = [...document.querySelectorAll('.section-tile')], count = document.getElementById('sectionCount');
   const label = document.documentElement.lang === 'fr' ? 'sections trouvées' : 'matching sections';
   const apply = () => {
      const q = search.value.trim().toLocaleLowerCase();
      let n = 0;
      for(const tile of items){const show=tile.dataset.name.includes(q);tile.hidden=!show;if(show)n++;}
      count.textContent=n+' '+label;
   };
   search.addEventListener('input',apply);
   document.getElementById('clearSectionSearch').addEventListener('click',()=>{search.value='';apply();search.focus()});
 }
 const settingSearch=document.getElementById('settingQuery');
 if(settingSearch){
   const rows=[...document.querySelectorAll('.setting-row')], counter=document.getElementById('settingCount');
   settingSearch.addEventListener('input',()=>{
     const q=settingSearch.value.trim().toLocaleLowerCase();let n=0;
     for(const row of rows){let show=row.querySelector('summary').textContent.toLocaleLowerCase().includes(q)||row.textContent.toLocaleLowerCase().includes(q);row.hidden=!show;if(show)n++;}
     counter.textContent=n+' '+(document.documentElement.lang==='fr'?'paramètres trouvés':'matching settings');
   });
 }
})();
</script>
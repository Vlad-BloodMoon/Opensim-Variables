<?php
declare(strict_types=1);
require_once __DIR__.'/inc/site.php';
require_once __DIR__.'/inc/ini-origin.php';
$csv=__DIR__.'/INI.CSV';
$records=[];$sections=[];$counts=[];
$error='';
if (!is_readable($csv)) $error=t('Fichier INI.CSV introuvable','INI.CSV not found');
else {
  $fd=fopen($csv,'rb');
  if ($fd === false) $error=t('Impossible de lire INI.CSV','Cannot read INI.CSV');
  else {
    $keys=fgetcsv($fd,0,',','"','');
    if(is_array($keys)){
      $keys=array_map(static fn($v)=>preg_replace('/^\\xEF\\xBB\\xBF/','',(string)$v),$keys);
      while(($values=fgetcsv($fd,0,',','"',''))!==false){
        if(count($values)!==count($keys))continue;
        $r=array_combine($keys,$values);
        if(!is_array($r)||trim((string)($r['IniFiles']??''))==='')continue;
        $records[]=$r;
        $sections[(string)($r['Section']??'')]=true;
        foreach(array_unique(array_values(ini_sources($r['IniFiles']))) as $kind) $counts[$kind]=($counts[$kind]??0)+1;
      }
    }
    fclose($fd);
  }
}
ksort($sections,SORT_NATURAL|SORT_FLAG_CASE);
$types=['defaults','template','include','robust','module','simulator','other'];
$kind=(string)($_GET['type']??'');
if(!in_array($kind,$types,true))$kind='';
$section=(string)($_GET['section']??'');
if(!isset($sections[$section]))$section='';
$filtered=array_values(array_filter($records,static function($r)use($kind,$section){
  return ($kind===''||in_array($kind,ini_sources($r['IniFiles']),true))
    && ($section===''||($r['Section']??'')===$section);
}));
begin_page('Référence des paramètres INI','INI settings reference',
'Paramètres avec références INI : origine du fichier, section, type et explication du contexte.',
'INI-referenced settings: source file category, section, type and context.');
callout('Ce catalogue indique où des paramètres ont été repérés, PAS les valeurs actives de votre serveur. Les catégories peuvent se chevaucher : un paramètre cité dans OpenSimDefaults.ini peut aussi être présent dans un modèle ROBUST.','This catalog reports where settings were found, NOT the values active on your server. Categories overlap: one setting may appear in OpenSimDefaults.ini and a ROBUST template.');
if($error!=='')echo '<p>'.e($error).'</p>';
else {
  echo '<p><a href="sections.php?lang='.e($lang).'">'.e(t('Sections A–Z','Sections A–Z')).'</a> · <a href="dictionary.php?lang='.e($lang).'">'.e(t('Variables du code sans référence INI','Code-only entries')).'</a></p>';
  echo '<form method="get" class="searchbar"><input type="hidden" name="lang" value="'.e($lang).'"><select name="type"><option value="">'.e(t('Toutes les origines','All source categories')).'</option>';
  foreach($types as $type)echo '<option value="'.e($type).'" '.($type===$kind?'selected':'').'>'.e(ini_kind_name($type)).' ('.(int)($counts[$type]??0).')</option>';
  echo '</select><select name="section"><option value="">'.e(t('Toutes les sections','All sections')).'</option>';
  foreach(array_keys($sections) as $name)echo '<option value="'.e($name).'" '.($name===$section?'selected':'').'>'.e($name).'</option>';
  echo '</select><button class="copy" type="submit">'.e(t('Filtrer','Filter')).'</button></form>';
  echo '<div class="searchbar"><input id="liveSearch" type="search" placeholder="'.e(t('Recherche dans les résultats…','Search within results…')).'" aria-label="Search"></div>';
  echo '<p id="matchCount">'.count($filtered).' '.e(t('paramètres','settings')).'</p><div id="settings">';
  foreach($filtered as $r){
    echo '<details class="record ini-result"><summary><code>'.e($r['Name']??'').'</code> · ['.e($r['Section']??'').']</summary>';
    ini_provenance($r);
    echo '<p><strong>'.e(t('Valeur du catalogue','Catalog value')).':</strong> <code>'.e($r['Value']??'').'</code> · <strong>'.e(t('Type','Type')).':</strong> '.e($r['Type']??'').'</p>';
    echo '<p><strong>'.e(t('Description originale (anglais)','Original English description')).':</strong> '.e($r['Description']??'').'</p>';
    echo '<p><strong>'.e(t('Référence C#','C# reference')).':</strong> '.e($r['SourceFiles']??'').'</p></details>';
  }
  echo '</div>';
}
end_page();
?>
<script>
(()=>{const input=document.getElementById('liveSearch');if(!input)return;const rows=[...document.querySelectorAll('.ini-result')];const counter=document.getElementById('matchCount');input.addEventListener('input',()=>{const q=input.value.toLocaleLowerCase();let count=0;for(const row of rows){const show=row.textContent.toLocaleLowerCase().includes(q);row.hidden=!show;if(show)count++}counter.textContent=count+' '+(document.documentElement.lang==='fr'?'résultats':'results')})})();
</script>
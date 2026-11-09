<?php
declare(strict_types=1);
// Classification de la provenance, pas de la configuration chargée.
function ini_sources(string $refs): array {
  $out=[];
  foreach (preg_split('/\\s+\\|\\s+/',trim($refs)) ?: [] as $entry) {
    $p=preg_replace('/:\\d+$/','',trim($entry));
    if ($p==='') continue;
    $l=strtolower(str_replace('\\\\','/',$p));
    if (preg_match('~(?:/proto/|\\.example$|\\.proto$|/tests?/|\\.tests?\\.ini$)~',$l)) $kind='template';
    elseif (str_contains($l,'opensimdefaults.ini')) $kind='defaults';
    elseif (preg_match('~(?:^|/)robust(?:\\.hg)?\\.ini$~',$l)) $kind='robust';
    elseif (str_contains($l,'/config-include/')) $kind='include';
    elseif (str_contains($l,'addon-modules/') || str_contains($l,'wifi.ini')) $kind='module';
    elseif (preg_match('~(?:^|/)opensim\\.ini$~',$l)) $kind='simulator';
    else $kind='other';
    $out[$p]=$kind;
  }
  return $out;
}
function ini_kind_name(string $kind): string {
  return match($kind) {
    'defaults'=>t('Valeurs par défaut','Shipped defaults'),
    'template'=>t('Modèle / exemple / test','Template / example / test'),
    'robust'=>t('ROBUST','ROBUST'),
    'include'=>t('Configuration incluse','Included configuration'),
    'module'=>t('Module complémentaire','Optional module'),
    'simulator'=>t('OpenSim.ini','OpenSim.ini'),
    default=>t('Autre fichier','Other file')
  };
}
function ini_provenance(array $record): void {
  $sources=ini_sources((string)($record['IniFiles']??''));
  $types=array_unique(array_values($sources));
  echo '<div class="ini-labels">';
  foreach ($types as $k) echo '<span class="ini-tag">'.e(ini_kind_name($k)).'</span>';
  echo '</div><p><strong>'.e(t('Fichiers référencés','Referenced files')).':</strong></p><ul>';
  foreach ($sources as $path=>$kind) echo '<li><code>'.e($path).'</code> — '.e(ini_kind_name($kind)).'</li>';
  echo '</ul><p class="muted">'.e(t('Ceci indique une provenance, pas une activation. Modifiez uniquement le fichier chargé par votre architecture. Pour le simulateur, vérifiez la valeur effective avec config show. Les fichiers .example doivent être copiés et adaptés avant utilisation.','This is provenance, not active configuration. Edit only files loaded by your architecture. On a simulator check effective values with config show. .example files must be copied and customized before use.')).'</p>';
}

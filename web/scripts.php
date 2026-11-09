<?php
require_once __DIR__.'/inc/site.php';
begin_page('Référence des fonctions OSSL','OSSL function reference',
'Index de fonctions extrait du code OpenSimulator : recherche, signatures C# et sources pour approfondir.',
'Function index extracted from OpenSimulator source: searchable names, C# signatures and source references.');
sec('Comprendre LSL et OSSL','Understanding LSL and OSSL');
p('LSL permet de programmer les objets du monde. OSSL ajoute des fonctions spécifiques aux simulateurs OpenSimulator, dont l’accès dépend des permissions et de la configuration du moteur de scripts.',
'LSL scripts in-world objects. OSSL adds simulator-specific functions whose availability depends on engine configuration and permissions.');
callout('Cet index est extrait de OSSL_Api.cs du fork analysé. Une méthode publique C# ne garantit pas à elle seule qu’elle est exposée au compilateur LSL, autorisée pour votre avatar ou présente dans votre version. Les signatures affichées sont des signatures C#, parfois tronquées sur plusieurs lignes ; utilisez le code et le wiki pour la signature de script exacte.',
'This index is extracted from OSSL_Api.cs of the inspected fork. A public C# method alone does not guarantee LSL script exposure, permission or availability in your version. Displayed signatures are C# declarations, occasionally cut across multiple lines; consult source and wiki for exact scripting syntax.');
sec('Rechercher une fonction','Find a function');
$functions = json_decode(file_get_contents(__DIR__.'/data/ossl-functions.json'),true) ?: [];
echo '<div class="searchbar"><input id="osslSearch" type="search" placeholder="'.e(t('osTeleportAgent, osGetAvatarList…','osTeleportAgent, osGetAvatarList…')).'" aria-label="OSSL Search"><select id="osslGroup"><option value="">'.e(t('Toutes les familles','All groups')).'</option></select></div>';
echo '<p id="osslCount"></p><div id="osslResults"></div>';
echo '<script type="application/json" id="osslData">'.json_encode($functions,JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT).'</script>';
sec('Sécurité et restrictions','Security and restrictions');
p('Ne désactivez pas globalement les contrôles de sécurité pour faire fonctionner un script. Vérifiez les paramètres de fonctions OSSL dans la configuration active du simulateur et l’aide de chaque fonction dans le wiki. Les exemples doivent être testés sur une région isolée.',
'Do not disable security checks globally to make one script work. Review active OSSL function restrictions and function-specific wiki documentation. Test examples in an isolated region.');
echo '<p><a href="https://opensimulator.org/wiki/OSSL_Implemented">OSSL implemented (Wiki)</a> · <a href="https://github.com/Vlad-BloodMoon/opensim/blob/master/OpenSim/Region/ScriptEngine/Shared/Api/Implementation/OSSL_Api.cs">OSSL_Api.cs</a></p>';
end_page();
?>
<script>
(()=>{const records=JSON.parse(document.getElementById("osslData").textContent),language=document.documentElement.lang,el=document.getElementById("osslResults"),search=document.getElementById("osslSearch"),group=document.getElementById("osslGroup"),count=document.getElementById("osslCount");
const esc=s=>String(s??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]));
function kind(n){if(/Terrain|Water|Sun|Wind|Environment|Sky/i.test(n))return "Terrain / Environment";if(/Teleport|Region|Estate|Parcel|Land/i.test(n))return "Region / Teleport";if(/Avatar|Npc|Agent|Presence/i.test(n))return "Avatars / NPC";if(/DynamicTexture|Draw|Texture|Prim|Link|Object|Mesh/i.test(n))return "Objects / Textures";if(/Message|Chat|Email|Notice|Dialog|Console/i.test(n))return "Messages / Console";if(/List|String|Json|AES|Hash|Date|Time|Math/i.test(n))return "Data / Utilities";return "Other";}
const kinds=[...new Set(records.map(x=>kind(x.name)))].sort();for(const c of kinds){const o=document.createElement("option");o.value=c;o.textContent=c;group.appendChild(o)}
function draw(){const q=search.value.toLowerCase(),g=group.value;const a=records.filter(x=>(!g||kind(x.name)===g)&&(!q||x.name.toLowerCase().includes(q)||x.signatures.join(" ").toLowerCase().includes(q)));count.textContent=a.length+" "+(language==="fr"?"fonctions":"functions")+" / "+records.length;el.innerHTML=a.map(x=>'<details class="record"><summary>'+esc(x.name)+' <small>· '+esc(kind(x.name))+'</small></summary><p><b>'+(language==="fr"?"Déclarations C#":"C# declarations")+'</b></p><pre>'+x.signatures.map(esc).join("\n")+'</pre><p><a target="_blank" rel="noopener" href="https://github.com/Vlad-BloodMoon/opensim/blob/master/OpenSim/Region/ScriptEngine/Shared/Api/Implementation/OSSL_Api.cs#L'+x.sourceLine+'">'+(language==="fr"?"Voir dans le code":"View source")+'</a> · <a target="_blank" rel="noopener" href="https://opensimulator.org/wiki/Special:Search?search='+encodeURIComponent(x.name)+'">'+(language==="fr"?"Rechercher dans le wiki":"Search wiki")+'</a></p></details>').join("")}search.addEventListener("input",draw);group.addEventListener("change",draw);draw();})();
</script>
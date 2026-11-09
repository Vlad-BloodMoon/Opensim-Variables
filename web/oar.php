<?php require_once __DIR__.'/inc/site.php';begin_page('Archives OAR : sauvegarde, importation et fusion','OAR archives: backup, import and merge','Commandes détaillées, options contrôlées dans le code OpenSimulator et scénarios de restauration.','Detailed commands, source-verified flags and restore scenarios.');
sec('Comprendre une archive OAR','Understanding an OAR');p('Un OAR contient les données d’une région (objets, terrain, parcelles et, selon les options, assets). L’enregistrement se fait depuis la console d’une région. Ne confondez pas archive région et archive d’inventaire IAR.','An OAR holds region data (objects, terrain, parcels and optionally assets). Save it through a region console. Do not confuse it with an IAR inventory archive.');
sec('Sauvegarder une région','Saving a region');
sample('save oar /backups/MyRegion.oar','Sauvegarde habituelle avec assets.','Normal backup including assets.');
sample('save oar --noassets /backups/MyRegion-noassets.oar','Sauvegarde sans intégrer les données des assets. Les UUID référencés restent nécessaires à une restauration complète.','Backup omitting asset data. Referenced UUIDs still need to resolve for a full restore.');
sample('save oar --all /backups/MyRegion-all.oar','Option --all reconnue dans le code de sauvegarde ; vérifier les implications sur votre version avant utilisation.','The save implementation accepts --all; check its precise implications for your version.');
subheading('Options de save oar','save oar flags');
options_table([
['--noassets','Ne pas inclure les assets','Omit asset data','Restauration dépendante de la présence des assets','Restore depends on asset availability'],
['-h, --home=URL','Renseigner l’URL de service d’origine','Attach a home service URL','Réservé aux cas qui en ont besoin','Use only when applicable'],
['--publish','Effacer les informations de propriété lors de l’export','Clear ownership information while exporting','Modifie les métadonnées exportées','Changes exported metadata'],
['--perm=CTM','Filtrer selon les permissions Copy/Transfer/Modify','Permission-based export filter','Peut exclure des objets','Can exclude objects'],
['--all','Demander un export étendu selon le code','Request extended export per implementation','Fonctionnement à confirmer selon la version','Verify release-specific behavior']
]);
sec('Restaurer une archive','Restoring an archive');
callout('ATTENTION : une restauration sans fusion peut remplacer les objets, le terrain ou les parcelles de la région cible. Faites un OAR de secours et testez sur une région jetable.','WARNING: a non-merge restore can replace objects, terrain or parcels in the target region. Back up first and test on a disposable region.');
sample('load oar /backups/MyRegion.oar','Restauration classique dans la région sélectionnée.','Basic restore to the selected region.');
sample('load oar --merge /backups/MyRegion.oar','Fusionne l’archive dans une région existante, au lieu d’effectuer un remplacement global.','Merges archive content into an existing region rather than a full replacement.');
sample('load oar --merge --merge-terrain --merge-parcels /backups/MyRegion.oar','Fusion avec demande explicite de traitement du terrain et des parcelles.','Merge with explicit handling of terrain and parcels.');
sample('load oar --skip-assets /backups/MyRegion.oar','Ignore l’importation des assets contenus dans l’archive ; ils doivent déjà être accessibles.','Skip importing assets from the archive; those assets must already be available.');
sample('load oar --merge --displacement "<256,0,0>" /backups/MyRegion.oar','Décale les objets importés de 256 m sur X. Contrôlez limites et positionnement avant import définitif.','Offsets imported objects by 256 m on X. Check bounds and placement before the final import.');
sample('load oar --merge --rotation 90 /backups/MyRegion.oar','Effectue une rotation pendant l’importation (en degrés). Tester le résultat sur une région isolée.','Rotates imported content (degrees). Test on an isolated region.');
subheading('Options de load oar','load oar flags');
options_table([
['--merge, -m','Fusionner au lieu de remplacer','Merge rather than replace','Vérifier doublons et objets déjà présents','Check duplicates and existing objects'],
['--mergeReplaceObjects','Fusion avec remplacement des objets correspondants','Merge with matching object replacement','Risque d’écraser des objets présents','May overwrite existing objects'],
['--skip-assets, -s','Ne pas importer les assets de l’OAR','Do not import assets from the OAR','Différent de --noassets à la sauvegarde','Different from --noassets during save'],
['--force-assets','Forcer le traitement des assets de l’archive','Force processing of archived assets','Évaluer l’impact avant utilisation','Assess impact before use'],
['--merge-terrain','Prendre aussi en compte le terrain en fusion','Include terrain during merge','Peut modifier les hauteurs','May change terrain heights'],
['--merge-parcels','Prendre en compte les parcelles en fusion','Include parcels during merge','Peut modifier les parcelles existantes','May alter existing parcels'],
['--no-objects','Ne pas restaurer les objets','Skip object restoration','Utile pour des restaurations sélectives','Useful for selective restores'],
['--displacement="<x,y,z>"','Décaler les positions importées','Offset imported positions','Valeurs en mètres','Values in metres'],
['--rotation=DEGREES','Appliquer une rotation','Apply a rotation','De -360 à 360 degrés','From -360 to 360 degrees'],
['--bounding-origin="<x,y,z>"','Origine de la zone d’import','Origin of import bounds','Usage avancé, tester avant production','Advanced: test before production'],
['--bounding-size="<x,y,z>"','Dimensions de la zone d’import','Size of import bounds','Usage avancé, tester avant production','Advanced: test before production'],
['--default-user=NAME','Propriétaire de substitution lors de l’import','Fallback owner during import','Sensible pour les permissions','Permission-sensitive'],
['--debug, -d','Activer les messages de débogage','Enable debug messages','Peut produire davantage de logs','May produce extra logs']
]);
sec('Exemple : restaurer dans une varregion','Example: restoring into a varregion');
p('Commencez par créer une varregion avec SizeX/SizeY adaptés, sauvegardez la région cible, puis utilisez une fusion et un décalage uniquement après avoir calculé la position souhaitée. Un OAR ne modifie pas automatiquement SizeX et SizeY de la région.','Create a varregion with the required SizeX/SizeY first, back up the target region, then use merge and displacement only after calculating the target position. An OAR does not automatically change the target region SizeX and SizeY.');
sample('load oar --merge --displacement "<256,256,0>" /backups/region256.oar','Exemple pédagogique : insertion d’une archive de région dans une varregion, à l’intérieur de ses dimensions.','Illustrative import of a region archive into a larger varregion, within its bounds.');
sec('Commandes et sources','Commands and sources');
p('La liste des options de cette page provient du parseur de commandes ArchiverModule.cs de ton fork OpenSimulator. Les exemples de positionnement doivent être validés pour chaque terrain.','The flags above come from the command parser in the OpenSimulator fork’s ArchiverModule.cs. Placement examples must be validated for the target terrain.');
echo '<p><a href="https://github.com/Vlad-BloodMoon/opensim/blob/master/OpenSim/Region/CoreModules/World/Archiver/ArchiverModule.cs">ArchiverModule.cs</a> · <a href="https://opensimulator.org/wiki/OpenSim_Archives">OpenSimulator Archives Wiki</a></p>';end_page();
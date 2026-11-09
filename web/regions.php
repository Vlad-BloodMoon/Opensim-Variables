<?php require_once __DIR__.'/inc/site.php';begin_page('Régions, fichiers Regions.ini et varregions','Regions, Regions.ini files and varregions','Créer une région, comprendre les dimensions, et préparer l’importation d’archives.','Create regions, understand dimensions, and prepare archive imports.');
sec('Fichiers de régions','Region configuration files');p('Les régions possèdent leur propre configuration, habituellement dans bin/Regions/. Ne confondez pas les paramètres de la région avec ceux du simulateur.','Regions use dedicated configuration, commonly under bin/Regions/. Do not confuse region-specific settings with simulator settings.');
sample('[Example Region]\nRegionUUID = 00000000-0000-0000-0000-000000000001\nLocation = 1000,1000\nInternalAddress = 0.0.0.0\nInternalPort = 9000\nAllowAlternatePorts = False\nExternalHostName = SYSTEMIP\nSizeX = 512\nSizeY = 512','Illustration d’une varregion 512 × 512. Remplacez l’UUID, l’emplacement et le port. Les noms et valeurs doivent être adaptés à votre réseau.','Illustrative 512 × 512 varregion. Replace UUID, location and port. Adapt names and values to your network.');
sec('Paramètres importants','Important settings');
options_table([
['RegionUUID','Identifiant unique de la région','Unique region identifier','Ne pas réutiliser entre régions','Do not reuse across regions'],
['Location','Position sur la carte','Map coordinates','Tenir compte des régions voisines','Consider neighboring regions'],
['InternalAddress','Adresse d’écoute locale','Local listening address','0.0.0.0 écoute toutes les interfaces','0.0.0.0 listens on all interfaces'],
['InternalPort','Port réseau du simulateur','Simulator network port','Éviter les conflits de port','Avoid port conflicts'],
['ExternalHostName','Nom ou IP accessible de l’extérieur','Externally reachable host/IP','Vérifier DNS et pare-feu','Verify DNS and firewall'],
['SizeX / SizeY','Dimensions de la région en mètres','Region dimensions in metres','Multiples de 256, taille carrée selon le code de ce fork','Multiples of 256, square according to this fork']
]);
sec('Importer une archive sur une grande région','Importing an archive into a large region');
p('Le chargement d’un OAR ne redimensionne pas votre région. Créez d’abord la région à la bonne taille, puis importez l’archive avec un décalage si nécessaire. Sauvegardez la cible avant l’opération.','Loading an OAR does not resize your region. First create a region with the correct dimensions, then import with a displacement if necessary. Back up the target beforehand.');
sample('load oar --merge --displacement "<256,0,0>" /backups/region.oar','Fusion et décalage de 256 m sur X ; utiliser sur une région d’essai.','Merge and shift 256 m on X; test in a disposable region.');
echo '<p><a href="https://github.com/Vlad-BloodMoon/opensim/blob/master/OpenSim/Framework/RegionInfo.cs">RegionInfo.cs</a> · <a href="oar.php?lang='.e($lang).'">'.e(t('Guide OAR détaillé','Detailed OAR guide')).'</a></p>';end_page();
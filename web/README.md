# OpenSimulator Handbook — PHP Encyclopedia (FR / EN)

**Community reference for OpenSimulator**, with independent PHP pages, exact command options grounded in the OpenSimulator source, practical restore procedures, diagnostic guides, and a searchable technical catalog.

## Deployment / Installation

1. Back up your existing web directory.
2. Download the branch `opensim-variables-web`.
3. Copy **all the contents** of the repository's `web/` directory into the existing website directory, e.g. `/var/www/BloodMoon/OpenSim_Variables/`.
4. Copy the file **`INI.CSV` from the repository root** into the same website directory as `dictionary.php`.
5. Open **`https://YOUR-DOMAIN/OpenSim_Variables/index.php`**.
6. If you still have an older `index.html` in the target web directory, **rename it to `index.html.backup`** after saving a backup. Otherwise the folder URL may continue to show the old HTML version depending on your web server.
7. Check these direct URLs: `oar.php`, `iar.php`, `regions.php`, `scripts.php` and `dictionary.php`.

Required layout:
```
OpenSim_Variables/
    index.php
    oar.php
    iar.php
    regions.php
    configuration.php
    sections.php            <- browsable alphabetical INI sections
    ini-parameters.php      <- INI-referenced entries only
    console.php
    procedures.php
    troubleshooting.php
    performance.php
    voice.php
    voice-install.php
    voice-config.php
    voice-conferences.php
    voice-troubleshooting.php
    scripts.php
    dictionary.php
    sources.php
    INI.CSV                  <- copy from repository root
    inc/site.php
    assets/site.css
    assets/site.js
    data/ossl-functions.json
```
Requires PHP 8+ and a conventional HTTP(S) web server. No database, framework or JS build.

## Existing content
- OAR: load/save, assets, merge, terrain/parcels, displacement, rotation, filtering and safeguards.
- IAR: full and no-asset backups, permissions and exclusions, --merge, creator information.
- Regions and varregions: region INI syntax, size rules, ports and placement.
- Console, configuration precedence, complete backup/restore walkthroughs and troubleshooting.
- Performance: measuring CPU, memory, disk, physics, scripts and service bottlenecks.
- Independent self-hosted voice chapter: installation, two-key configuration, matching modules, AdHoc API and troubleshooting. This chapter is based on BloodMoon-Voice v1.0.0 and OpenSimulator v0.9.3.1-webrtc.3.
- OSSL: **266 unique public os-prefixed methods** extracted from `OSSL_Api.cs` (297 declarations including overloads), with code references and wiki search links. Not all source methods necessarily map to callable/safe functions.
- INI section browser: filters the CSV to entries with INI file references and omits unresolved section names; some example-only or optional module entries remain.
- INI parameters: only records with a non-empty IniFiles reference (including examples and optional modules).
- Code-only variables (dictionary.php): only records with an empty IniFiles reference. The two result sets do not overlap.

## Editorial safeguards
The documentation is **not yet exhaustive** and is not affiliated with the OpenSimulator project.
Source verification is from the inspected `Vlad-BloodMoon/opensim` master branch as of November 2026. Confirm commands against your installed version before running them. Never publish passwords or tokens. Treat all archive imports as potentially destructive.

## Primary sources
- https://opensimulator.org/wiki/Main_Page
- https://opensimulator.org/wiki/OpenSim_Archives/fr
- https://opensimulator.org/wiki/Inventory_Archives
- https://opensimulator.org/wiki/Performance
- https://opensimulator.org/wiki/OSSL_Implemented
- https://github.com/Vlad-BloodMoon/opensim

## Contribution policy
Submit documentation corrections with exact source references, target version and a reproducible example. Include both English and French when possible.

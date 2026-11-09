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
    installation.php
    install-platforms.php
    install-standalone.php
    install-grid.php
    install-first-login.php
    install-checklist.php
    install-logs.php         <- OpenSim / ROBUST log analysis first
    install-network.php
    install-hypergrid.php
    oar.php
    iar.php
    regions.php
    configuration.php
    sections.php            <- browsable alphabetical INI sections
    ini-parameters.php      <- INI references, categorized by source files
    inc/ini-origin.php      <- source-file classifier for INI entries
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

## INI provenance / Origine des références

On `ini-parameters.php`, users can filter entries by section and source-file category: OpenSimDefaults.ini, example/prototype/test templates, config-include architecture files, ROBUST files, optional module configs, OpenSim.ini and other INI files. One entry can have several source categories; category totals overlap.

On `sections.php`, each listed parameter also shows its file references and category. These references describe **where the parameter was found in the CSV**, NOT which files are loaded or which parameter value is active on your installation. Consult simulator `config show` and the active ROBUST configuration to establish effective settings. No live grid configuration is accessed by this site.

## Installation learning path (FR / EN)

- `installation.php`: target version, architecture decision, SDK/build and prerequisites. Ubuntu is an example, NOT a requirement.
- `install-platforms.php`: operating-system-specific paths for Windows, Linux distributions and macOS.
- `install-standalone.php`: minimal single-process setup, SQLite default, first region.
- `install-grid.php`: MySQL, ROBUST, GridCommon.ini, distributed regions.
- `install-first-login.php`: create a user, login URI and viewer checks.
- `install-checklist.php`: troubleshooting by symptom.

Reference base: `Vlad-BloodMoon/opensim` `BUILDING.md`, `bin/OpenSim.ini.example`, `bin/config-include/StandaloneCommon.ini.example`, `bin/config-include/GridCommon.ini.example` and `bin/Robust.ini.example`. These are guided example procedures, not claims of tested production deployment. Do not treat the README in the fork as current voice-release documentation: review the dedicated BloodMoon-Voice repository for that.

## Hypergrid and network expansion

- `install-hypergrid.php`: StandaloneHypergrid, GridHypergrid, ROBUST HG public connectors, HomeURI, GatekeeperURI, traveller inventory and cross-grid tests.
- `install-network.php`: reference port roles, public/private separation, region TCP/UDP, DNS/NAT, example UFW firewall and testing.
- Both chapters cite the matching 0.9.3.1 / .NET 8 fork source config files. Wiki primary pages could not be read directly when authored (website timeout); do not assert an exhaustive wiki transcription.

## Log-first troubleshooting

- `install-logs.php` covers OpenSim.log and Robust.log, the actual log4net configuration in `bin/OpenSim.exe.config` and `bin/Robust.exe.config`, live Linux and Windows reading, systemd journals, event correlation, MySQL service logs and safe sharing of extracts.
- Install and general troubleshooting pages now point to log analysis before blind changes or restarts.
- Paths and service unit names are illustrative; inspect each installation's working directory, log4net appender and service manager.

## Structured troubleshooting style

Every incident description in installation checks, archive/region troubleshooting, and WebRTC voice troubleshooting now follows a structured order: symptom and background → relevant logs → likely search terms (not guaranteed exact log messages) → read-only verification → conditional fix. Generic diagnostic markup is implemented in `inc/site.php`.

OpenSim.log and Robust.log are distinct and often both relevant; read `install-logs.php` before modifying configuration. Back up logs and redact sensitive details before sharing.

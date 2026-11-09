# OpenSimulator Handbook — PHP site (FR/EN)

Community OpenSimulator reference, organized as independent PHP chapters.

## Deployment / Déploiement

1. Copy the *contents* of this `web/` directory to your desired public web directory, e.g. `/var/www/BloodMoon/OpenSim_Variables/`. Do NOT upload the `web` folder as an extra level unless you want that URL.
2. Copy the **repository root** `INI.CSV` into **the same directory as `dictionary.php`**.
3. Open `https://your-domain/OpenSim_Variables/index.php`.
4. PHP 8+ recommended; no database required. If the server still serves the old `index.html` at the folder URL, either move/delete the old file after backing it up or explicitly visit `index.php`. Do not delete your old site until tested.

Required layout:
```
OpenSim_Variables/
  index.php
  configuration.php
  regions.php
  oar.php
  iar.php
  performance.php
  scripts.php
  dictionary.php
  sources.php
  INI.CSV
  inc/site.php
  assets/site.css
  assets/site.js
```

### Documentation status
- OAR and IAR flags were checked against OpenSimulator fork command parsers; some advanced semantics require further testing.
- This is a usable first technical edition, not a complete replacement for official documentation.
- Consult the wiki and implementation for version-specific behavior.
- Do not publish credentials. Always back up before testing archive imports.

Sources:
- https://github.com/Vlad-BloodMoon/opensim
- https://opensimulator.org/wiki/OpenSim_Archives/fr
- https://opensimulator.org/wiki/Inventory_Archives
- https://opensimulator.org/wiki/Performance
- https://opensimulator.org/wiki/OSSL_Implemented

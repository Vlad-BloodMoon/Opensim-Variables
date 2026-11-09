# OpenSimulator Handbook / Guide OpenSimulator

A public, bilingual (English / French), beginner-friendly documentation site for OpenSimulator.

## Installation
- The website lives in `web/index.html`.
- Copy `web/index.html` and the repository's root `INI.CSV` **to the same directory** on your web server.
- Serve over HTTP(S); `file://` may block the CSV request.
- No server-side software, database or build pipeline required.
- For GitHub Pages, set a publish directory containing both files (for example copy them to the root of a publishing branch).

## Sections
- Getting started with INI syntax, comments, defaults, debugging via `config show`
- Main simulator and ROBUST config files and INI overrides
- Explanations of common sections and usage patterns
- Practical performance diagnostic checklist
- OAR / IAR archive and restore fundamentals
- LSL / OSSL fundamentals and security
- Searchable full INI catalog (1,933 entries in the provided dataset)
- Primary documentation and source links

## Important editorial limitations
This is a community reference, not official OpenSimulator documentation. Version-specific commands, available flags, behavior and safe settings must be checked against the running release. Not every catalog description is human-verified; inferred values may be incomplete or outdated. Never expose secrets from your private INI files.

## Primary references
- https://opensimulator.org/wiki/Main_Page
- https://opensimulator.org/wiki/Performance
- https://opensimulator.org/wiki/OpenSim_Archives/fr
- https://opensimulator.org/wiki/Inventory_Archives
- https://opensimulator.org/wiki/OSSL_Implemented
- https://github.com/Vlad-BloodMoon/opensim

No references to third-party distributions are used as the basis of the web guide.

## Future contributions
Contributions should include bilingual text, reproduction steps, precise OpenSimulator versions, and primary source links. Prioritize tested examples and security cautions.

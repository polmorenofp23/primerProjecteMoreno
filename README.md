Project: Bees Cavern Web (primerProjecteMoreno)

Version: 0.1.0

Short description
-----------------
Bees Cavern is a small restaurant/menu management application written in PHP. It provides models, DAOs, controllers and views to manage products, ingredients, users, orders, discounts and related data. The codebase follows a lightweight MVC pattern (controllers, models, DAOs, views) and uses PDO for database access.

Where to keep this README
-------------------------
Place this `README.md` in the project root (the repository root). A root README is the standard place for project-level documentation and is automatically shown by code hosting platforms (GitHub, GitLab). Do NOT place this file under `public/` — that folder is served by the web server and should only contain public assets.

How to update the version
-------------------------
- When you prepare a new deploy/release, update the `Version:` line at the top of this file.
- Use semantic versioning (MAJOR.MINOR.PATCH), e.g. `0.1.1` → `0.2.0` → `1.0.0`.
- Optionally add a short changelog entry underneath the version line or keep a separate `CHANGELOG.md`.

Quick repo layout (important paths)
-----------------------------------
- `app/` — application code (controllers, models, DAOs, views)
  - `app/controller/` — controllers (including `ErrorController.php`)
  - `app/model/` — entity models
  - `app/DAO/` — data access objects (DB queries)
  - `app/view/` — PHP views and HTML templates
  - `app/utils/` — utility scripts (moved json utils here)
  - `app/core/` — core helpers (DatabasePDO.php, Router, Session..)
- `public/` — web root (index.php, public assets)
- `db/` — SQL scripts for schema and sample data
- `logs/` — runtime logs

Notes and suggestions
---------------------
- Keep configuration (DB credentials) out of public webroot and out of version control. Use environment variables or a local config file ignored by git.
- Put heavy assets (images) under `public/uploads/` and keep only sanitized filenames.
- Use `README.md` at root for project-level information and instructions for developers. Keep UI-level help (if any) inside `app/view/` or a separate `docs/` folder.

Contact
-------
Pol Moreno Queraltó — maintainer of this repo

---
(End of README)
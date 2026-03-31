# ForenDesk

ForenDesk is a Laravel 12 + MySQL application designed as a browser-based forensic command center for lawful digital forensics, evidence review, reporting, and guided cybersecurity education.

## Phase 1-2 Included

- Greenfield Laravel 12 scaffold in the repo root
- Breeze-based authentication foundation
- Multi-tenant organization model with active organization switching
- Session-backed internal `/api` routes using `web`, `auth`, `verified`, and `active.organization`
- Command-center route map and first-pass forensic workspace shell
- Full MySQL schema for organizations, cases, evidence, reports, audit, labs, notifications, settings, and processing jobs
- Eloquent models, relationships, factories, and demo seed data

## Local Setup

1. Copy `.env.example` to `.env`
2. Set MySQL credentials in `.env`
3. Run `composer install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`

Demo credentials after seeding:

- `admin@forendesk.test` / `password`
- `instructor@forendesk.test` / `password`
- `student@forendesk.test` / `password`

## Current Notes

- The app now includes the Phase 1 and Phase 2 architecture, schema, model layer, seeded demo workspace, and Blade route shells.
- AJAX modules, Blade component system, policies, tool services, and reporting execution flows are reserved for the next implementation phases.

## Docker

The repo now includes a Docker-based dev stack with:

- `app` running PHP 8.3 with `pdo_mysql`
- `mysql` for the primary database
- `redis` for supporting services
- `mailpit` for local SMTP testing
- `queue` and `scheduler` worker containers

Start the stack:

1. `docker compose up -d --build`
2. `docker compose exec app composer install`
3. `docker compose exec app php artisan migrate --seed`

Useful endpoints:

- App: `http://localhost:8000`
- Mailpit UI: `http://localhost:8025`

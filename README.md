# Shay Manufacturing CMS

A PHP/MySQL inventory and shipping management application built for Shay Manufacturing.

## Overview

This project includes:
- Product/SKU management
- Internal and warehouse inventory views
- MPL (Master Packing List) creation and tracking
- Orders workflow endpoints
- API-key protected JSON endpoints for integrations

## Tech Stack

- PHP (procedural + MySQLi)
- MySQL (phpMyAdmin / MAMP)
- HTML/CSS (custom styles)
- JavaScript (minimal, per-page)

## Project Structure

Top-level highlights:
- `index.php` — dashboard + products table
- `mpl.php` — create MPL shipping list from inventory items
- `mpl_items.php` — view MPL shipping records
- `orders.php` — order request page
- `i_inventory.php` — internal inventory page (styled table + metrics scaffold)
- `w_inventory.php` — warehouse inventory page scaffold
- `library/cms.php` — core form-processing logic (create/update/delete + MPL submit handler)
- `APIs/` — custom API endpoints (shipping, orders, product actions)
- `css/stylesheet.css` — global design + forms/tables/banner styles

## Local Setup (MAMP)

1. Place this project in your MAMP web root (`htdocs`).
2. Import your database SQL in phpMyAdmin (if needed).
3. Ensure `db_connect.php` points to the correct DB credentials.
4. Ensure `.env.php` exists at project root with API key and DB values.
5. Start MAMP Apache + MySQL.
6. Open in browser (example):
	 - `http://localhost/index.php`

## Environment File

Expected `.env.php` format:

```php
<?php
return [
		'DB_HOST' => 'localhost',
		'DB_NAME' => 'idm250_db',
		'DB_USER' => 'root',
		'DB_PASS' => 'root',
		'X-API-KEY' => 'test',
];
```

## Key User Flows

### 1) Create MPL

1. Go to `mpl.php`.
2. Enter reference number, ship date, trailer name.
3. Select inventory checkboxes.
4. Submit.
5. `library/cms.php` inserts selected items into `mpl_shipping_list`.
6. Redirects back to `mpl.php` with status banner.

### 2) Review MPL Records

1. Open `mpl_items.php`.
2. View all records from `mpl_shipping_list` joined with `inventory_item_info`.
3. Use row actions:
	 - Edit: `APIs/mpl-update.php?id=...`
	 - Delete: `APIs/mpl-delete.php?id=...`

### 3) Manage Products

- Add product: `APIs/product-new.php`
- Edit product: `APIs/product-update.php?id=...`
- Delete product: `APIs/product-delete.php?id=...`

## API Endpoints

### MPL Shipping API

- File: `APIs/mpl-shipping.php`
- Auth: header `X-API-KEY`

#### GET
Returns all shipping records.

#### POST
Creates a new shipping record.

Example body:

```json
{
	"item_id": 1,
	"reference_number": "20260225",
	"ship_date": "2026-03-05",
	"trailer_name": "Trailer-B",
	"status": "Pending"
}
```

### Orders API

- File: `APIs/api_orders.php`
- Auth: header `X-API-KEY`
- Accepts JSON and form-encoded post bodies

Example JSON body:

```json
{
	"order_send": true,
	"selected_items": [1, 2, 3]
}
```

## Testing (Yaak / Postman)

For protected endpoints, include headers:

```text
X-API-KEY: test
Content-Type: application/json
```

Suggested quick checks:
- `GET /APIs/mpl-shipping.php`
- `POST /APIs/mpl-shipping.php`
- `POST /APIs/api_orders.php`

## UI Conventions

- Buttons: `.btn` and `.btn-form` (gradient + glare hover)
- Tables: `.table-container` + `.data_tb`
- Form cards: `.form-section` / `.form-card-centered`
- Status banners:
	- success: `.status-banner.status-success`
	- warning: `.status-banner.status-warning`

## Notes

- `library/cms.php` is a form-processing endpoint; it does not render HTML pages.
- If you see a blank screen after submit, verify redirects and PHP errors are enabled.
- Some pages are still scaffolds and can be connected to additional live data over time.

## Next Improvements (Suggested)

- Add dedicated `mpl-update.php` logic bound to shipping record IDs
- Add pagination/filtering for long tables
- Add server-side validation/error flash messages per form
- Add role-based auth/session checks on all write actions

# Shay Manufacturing API and Integration Documentation

## 1) Overview
This project has two integration layers:
- JSON APIs (machine-to-machine) in the APIs folder
- Form/action handlers (browser-driven) in the library folder

Because both are used in production workflows, this document covers both.

## 2) Environment and Authentication

### Environment Source
- Environment values are loaded from .env.php
- Database connection is created in db_connect.php

### API Key Authentication
- API key check function: library/auth.php
- Required request header: X-API-KEY
- Expected value source: .env.php key X-API-KEY

### Current Default Values (local/dev)
- DB_HOST: localhost
- DB_NAME: idm250
- DB_USER: root
- DB_PASS: root
- X-API-KEY: test

## 3) Data Model and Status Lifecycle

### Core Tables Used by APIs/Actions
- inventory_item_info
- mpl_shipping_list
- order_list
- products
- products_dimensions
- products_types

### Status Values Seen in Code
- draft
- pending
- accepted

### Typical Lifecycle
- MPL flow: draft -> pending -> accepted
- Order flow: draft -> pending -> accepted

## 4) JSON API Endpoints (APIs folder)

## 4.1 APIs/api-mpl.php
Purpose:
- Main JSON endpoint for MPL records

Auth:
- Requires X-API-KEY

Methods:
- OPTIONS
  - Returns 204
  - Used for CORS preflight
- GET
  - Returns joined MPL and inventory data
  - Sort order: ship_date DESC
- POST
  - Mode A: status update when id and status are provided
    - Allowed statuses: pending, accepted
    - Updates mpl_shipping_list by id
  - Mode B: create one or many MPL rows
    - Required fields: reference_number or reference_numb or reference, ship_date or date, trailer_name or truck
    - Supports selected_items array or single item_id

Success Response Patterns:
- GET: JSON array of rows
- POST update: success, message, id, status
- POST create: success, message, count, ids

Error Patterns:
- 400 missing required fields
- 500 database or server error
- 405 method not allowed

## 4.2 APIs/api_orders.php
Purpose:
- JSON endpoint intended for order integration with external team

Auth:
- check_api_key is called

Methods:
- GET
  - Returns joined order and inventory data
  - Filter: only ol.status = pending
- POST
  - Mode A: if id and status are present, performs status update path
  - Mode B: create order shipping rows from payload

Expected Fields for Create Path:
- reference_number or reference_numb or reference
- ship_date or date
- trailer_name or truck
- address
- zip_code
- city
- state
- selected_items array or item_id

Important Behavior Notes:
- This file currently contains mixed logic and legacy code blocks.
- It also constructs an outbound HTTP call near the end of POST handling.

## 4.3 APIs/mpl-shipping.php
Purpose:
- Secondary JSON endpoint for MPL shipping records

Auth:
- Requires X-API-KEY

Methods:
- GET
  - Returns mpl_shipping_list joined with inventory_item_info
- POST
  - Inserts one new mpl_shipping_list row
  - Required: item_id, reference_number, ship_date, trailer_name
  - Optional: status (defaults to Pending in this file)

Response Shape:
- success boolean
- count for GET
- id for successful POST insert

## 4.4 APIs/api_call.php
Purpose:
- Generic call relay file used for MPL data retrieval and outbound HTTP setup

Auth:
- Requires X-API-KEY

Methods:
- GET
  - Returns joined MPL + inventory + product type data

Note:
- This file initializes an outbound call context using API_KEY from environment variables.

## 5) APIs Folder Pages (UI endpoints, not JSON APIs)
These files are in APIs but function as web pages/forms for CRUD workflows.

## 5.1 Product pages
- APIs/product-new.php
  - UI form to create a product
  - Submits to library/cms.php with add_btn
- APIs/product-update.php
  - UI form to edit an existing product
  - Submits to library/cms.php with update_btn
- APIs/product-delete.php
  - UI confirmation page for product deletion
  - Submits to library/cms.php with delete_btn

## 5.2 MPL package pages
- APIs/mpl-update.php
  - UI page to edit one MPL package and its items
  - Submits actions to library/cms_alt.php
- APIs/mpl-delete.php
  - Performs delete behavior and also renders a confirmation-style page

## 5.3 Order package pages
- APIs/orders-update.php
  - UI page to edit one order package and its items
  - Submits actions to library/cms_alt.php
- APIs/orders-delete.php
  - Deletes one order item when draft checks pass

## 6) Action Handler Endpoints (library folder)
These are integration-critical and are effectively part of the API surface.

## 6.1 library/cms.php
Handles:
- Product add/update/delete
- MPL submit/send/accept/update
- Order submit/send/accept/update
- Remove items from order package

Input source:
- Query string actions (for example send_order_id, accept_order_id)
- Form posts (for example add_btn, update_order_btn)

Return pattern:
- Mostly HTTP redirects to UI pages with status query params

## 6.2 library/cms_alt.php
Handles:
- Alternative/extended package editing actions
- MPL package update/add/remove item
- Order package update/add/remove item
- Send/accept transitions for MPL and Orders in alternate flows

Return pattern:
- Redirect with status flags to update/list pages

## 7) Request/Response Reference Examples

## 7.1 Example: Get MPL JSON
Endpoint: APIs/api-mpl.php
Method: GET
Headers:
- X-API-KEY: test

Expected:
- 200 with JSON array of MPL rows

## 7.2 Example: Update MPL Status
Endpoint: APIs/api-mpl.php
Method: POST
Headers:
- Content-Type: application/json
- X-API-KEY: test
Body:
- id: integer
- status: pending or accepted

Expected:
- 200 with success true, id, status

## 7.3 Example: Create Order Rows
Endpoint: APIs/api_orders.php
Method: POST
Headers:
- Content-Type: application/json
- X-API-KEY: test
Body fields:
- reference_number
- ship_date
- trailer_name
- address
- zip_code
- city
- state
- selected_items array or item_id

Expected:
- success true and created ids when insert path succeeds

## 8) Recommended Consumer Rules
- Always send X-API-KEY for JSON API calls.
- Use Content-Type application/json for POST payloads.
- Expect inconsistent response envelopes across endpoints.
- Confirm target endpoint behavior in this document before integrating.
- Treat library/cms.php and library/cms_alt.php as state transition endpoints for status workflow.

## 9) File Index Covered By This Document
- APIs/api-mpl.php
- APIs/api_orders.php
- APIs/mpl-shipping.php
- APIs/api_call.php
- APIs/product-new.php
- APIs/product-update.php
- APIs/product-delete.php
- APIs/mpl-update.php
- APIs/mpl-delete.php
- APIs/orders-update.php
- APIs/orders-delete.php
- library/cms.php
- library/cms_alt.php
- library/auth.php
- db_connect.php
- .env.php

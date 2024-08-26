# Changelog

## v0.0.6

- docs: readme, http client
- feat: added cli commands

## v0.0.5

- feat: separate sail bash command
- docs: update readme
- fix: removed Livewire
- fix: changed default variables in .env.example
- feat: included uninstall command to dev

## v0.0.4

- fix: fixed billing not listed after paid
- fix: auto refresh page after pix payment

## v0.0.3

- fix: added required fields for Mercadopago's Payment data
- fix: added X-Idempotency-Key to header post request when generating a Payment on MP 
- fix: fixed Mercadopagos's "date_of_expiration" field wrong pattern 
- feat: implemented billing view for approved payments
- feat: added CHANGELOG
- feat: changed Utils for Helpers
- fix: removed exposed private variables
 
## v0.0.2

- fix: authentication
- feat: websocket
- fix: removed http files
- feat: implemented unauthorized routes
- docs: added instructions about websockets server

## v0.0.1

- docs: lohl finance full documentation
- fix: disabled Mercadopago's signature verification
- fix: disabled Mercadospago's date_of_expiration
- fix: force status "pending" when creating a Payment
- fix: added "approved" step on PaymentService
- fix: code cleaning
- docs: added tasks file

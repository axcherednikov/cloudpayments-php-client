# Changelog

This file documents notable changes to the library.

## [4.0.0] - 2026-10-03

### Changed

- **Breaking:** `TransactionModel` and `TransactionWith3dsModel` constructors now
  require response data containing `TransactionId` instead of allowing empty
  construction followed by `fill()`.
- Transaction IDs are validated inside the SDK and exposed as exact PHP `int`
  values. Malformed, missing, floating-point, and out-of-range IDs throw
  `ResponseFormatException`, a subclass of `CloudpaymentsException`.
- Raw JSON integers retain their precision without conversion through `float`.
  The API documents `TransactionId` as `Long`; signed decimal-string
  normalization and native integer limits are SDK behavior.
- **Breaking for custom response subclasses:** response `model` properties now
  have the native `mixed` type. Redeclarations must use the same native type.

### Fixed

- Supplied transaction models are validated and hydrated even when
  `Success` is `false`, including 3-D Secure challenges and declined payments.
- Responses without a model remain valid, including successful payment
  confirmations and voids. Optional `model` properties retain their previous
  initial `null` value; existing empty-list defaults remain unchanged.

### Tests

- Added regression coverage for invalid IDs, native integer bounds, large raw
  JSON integers, overflow, transaction lists, failed payments, and 3-D Secure.
- Verified that hydrated IDs can be reused directly by existing request DTOs.
- Replaced manual exception-catching loops with PHPUnit data providers.

### Migration

- Use models returned by the SDK, or construct a model with response data:
  `new TransactionModel((object) ['TransactionId' => 123])`.
- Keep using `$model->transactionId` directly in request DTOs. Handle
  `ResponseFormatException` when reading an invalid API response; no duplicate
  ID-format validation is required in application code.
- In custom response subclasses, declare an overridden optional model as
  `public mixed $model = null;` and retain its appropriate PHPDoc model type.

## [3.3.0] - 2026-07-23

### Added

- Support for the CloudPayments `test` endpoint.
- Creation of payment links and retrieval of QR codes for SBP payments:
  `payments/qr/sbp/link` and `payments/qr/sbp/image`.
- Retrieval of the list of banks participating in SBP via `sbp/v2/banks/info`.
- Lookup of the latest operation by invoice ID via `v2/payments/find`.
- Retrieval of payment operations for an arbitrary date range via
  `v2/payments/list`.
- Retrieval of chargebacks via `chargebacks/list`.
- Typed request and response DTOs and enums for the new endpoints.
- The `CloudpaymentsData` DTO for building structured `JsonData`.
- Additional fiscal receipt requisites and VAT rates `5`, `7`, `22`, `5/105`,
  `7/107`, and `22/122`.
- The `errorCode` field in `CloudResponse`.

### Changed

- Stricter type validation for the main CloudPayments response fields.
- `TransactionArrayResponse::model` now defaults to an empty array.

### Backward compatibility

- Existing API methods and their signatures remain unchanged.
- Support for the new endpoints does not change the behavior of existing
  integrations.

## [3.2.4] - 2026-06-09

### Added

- PHPUnit, PHPStan, PHP CS Fixer, and Rector checks in CI.
- Tests for the API client, request and response DTOs, models, and webhook
  handlers.
- Expanded documentation covering installation, configuration, and usage.

### Changed

- Improved static typing without changing the public API.
- Updated the code to comply with PHPStan and Rector rules.

## [3.2.3] - 2026-06-08

### Added

- A CI test matrix for PHP `8.1-8.5`.
- Missing transaction model fields.
- `BaseModel::getAdditionalProperties()` for accessing unknown fields returned
  by CloudPayments.

### Fixed

- Unknown response fields no longer create dynamic model properties.

## [3.2.2] - 2025-06-10

### Added

- Composer Normalizer and Composer Bin Plugin.
- Isolated environments for PHPStan, PHP CS Fixer, and Rector.
- Makefile commands for dependency installation, testing, and code quality
  checks.

### Changed

- Development tool caches moved to the `tmp` directory.

## [3.2.1] - 2025-06-10

### Added

- Initial release of the CloudPayments PHP client.
- Support for card and token payments, refunds, confirmations, and voids.
- Support for subscriptions, orders, notifications, fiscal receipts, and
  Apple Pay.
- Request and response DTOs, response models, enums, and webhook handlers.
- Basic PHPUnit tests and code quality tools.

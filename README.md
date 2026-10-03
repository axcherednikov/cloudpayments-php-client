# CloudPayments PHP Client

[![Tests](https://github.com/axcherednikov/cloudpayments-php-client/actions/workflows/tests.yml/badge.svg)](https://github.com/axcherednikov/cloudpayments-php-client/actions/workflows/tests.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/axcherednikov/cloudpayments-php-client.svg)](https://packagist.org/packages/axcherednikov/cloudpayments-php-client)
[![PHP Version](https://img.shields.io/packagist/dependency-v/axcherednikov/cloudpayments-php-client/php.svg)](https://packagist.org/packages/axcherednikov/cloudpayments-php-client)
[![License](https://img.shields.io/packagist/l/axcherednikov/cloudpayments-php-client.svg)](LICENSE)

PHP-клиент для [CloudPayments API](https://developers.cloudpayments.ru/#api).
Пакет предоставляет DTO для запросов, DTO для ответов, обработку HTTP-запросов через Guzzle и классы для данных webhook-уведомлений.

Проект основан на кодовой базе `flowwow/cloudpayments-php-client`, развивается независимо и использует namespace `Excent\Cloudpayments`.

## Оглавление

- [Требования](#требования)
- [Установка](#установка)
- [Быстрый старт](#быстрый-старт)
- [3-D Secure](#3-d-secure)
- [Поддерживаемые методы](#поддерживаемые-методы)
- [Запросы](#запросы)
- [Ответы](#ответы)
- [Уведомления](#уведомления)
- [Идемпотентность](#идемпотентность)
- [Обработка ошибок](#обработка-ошибок)
- [Версионирование](#версионирование)
- [License](#license)

## Требования

- PHP `^8.1`
- Guzzle `^7.4`
- Composer

## Установка

```bash
composer require axcherednikov/cloudpayments-php-client
```

## Быстрый старт

```php
<?php

declare(strict_types=1);

use Excent\Cloudpayments\Library;
use Excent\Cloudpayments\Request\CardsPayment;

require __DIR__ . '/vendor/autoload.php';

$client = new Library(
    $_ENV['CLOUDPAYMENTS_PUBLIC_ID'],
    $_ENV['CLOUDPAYMENTS_API_PASSWORD']
);

$request = new CardsPayment(
    100.00,
    'RUB',
    '127.0.0.1',
    'CARD_CRYPTOGRAM_PACKET'
);

$response = $client->paymentsCardsCharge($request);

if ($response->success) {
    echo $response->model->transactionId;
}
```

Если нужно переопределить endpoint CloudPayments, передайте URL третьим аргументом конструктора:

```php
$client = new Library($publicId, $apiPassword, $customApiUrl);
```

## 3-D Secure

Методы `paymentsCardsCharge()` и `createPaymentByCard2Step()` возвращают `TransactionWith3dsResponse`. Если требуется 3-D Secure, `is3dsError()` вернет `true`, а данные для перенаправления будут доступны в `model`.

```php
use Excent\Cloudpayments\Request\Post3DS;

$response = $client->paymentsCardsCharge($request);

if ($response->is3dsError()) {
    $acsUrl = $response->model->acsUrl;
    $paReq = $response->model->paReq;
    $transactionId = $response->model->transactionId;

    // Передайте пользователя на страницу ACS банка, затем обработайте PaRes.
    $client->post3Ds(new Post3DS($transactionId, 'PARES_FROM_ACS'));
}
```

## Поддерживаемые методы

Библиотека работает с методами из [CloudPayments API](https://developers.cloudpayments.ru/#api) через request/response DTO.

| Метод API                          | Метод Library               | Request DTO               | Response DTO                 |
|------------------------------------|-----------------------------|---------------------------|------------------------------|
| `payments/cards/charge`            | `paymentsCardsCharge`       | `CardsPayment`            | `TransactionWith3dsResponse` |
| `payments/cards/auth`              | `createPaymentByCard2Step`  | `CardsPayment`            | `TransactionWith3dsResponse` |
| `payments/cards/post3ds`           | `post3Ds`                   | `Post3DS`                 | `TransactionResponse`        |
| `payments/tokens/charge`           | `executePaymentByToken`     | `TokenPayment`            | `TransactionResponse`        |
| `payments/tokens/auth`             | `createPaymentByToken2Step` | `TokenPayment`            | `TransactionResponse`        |
| `payments/confirm`                 | `confirmPayment`            | `PaymentsConfirm`         | `CloudResponse`              |
| `payments/void`                    | `cancelPayment`             | `PaymentsVoid`            | `CloudResponse`              |
| `payments/refund`                  | `paymentsRefund`            | `PaymentsRefund`          | `TransactionResponse`        |
| `payments/cards/topup`             | `paymentsCardsTopup`        | `CardsTopUp`              | `TransactionResponse`        |
| `payments/token/topup`             | `paymentsTokenTopup`        | `TokenTopUp`              | `TransactionResponse`        |
| `payments/get`                     | `getPaymentData`            | `PaymentsGet`             | `TransactionResponse`        |
| `payments/find`                    | `getPaymentDataByInvoice`   | `PaymentsFind`            | `TransactionResponse`        |
| `v2/payments/find`                 | `getPaymentDataByInvoiceV2` | `PaymentsFind`            | `TransactionResponse`        |
| `payments/list`                    | `getListPayment`            | `PaymentsList`            | `TransactionArrayResponse`   |
| `v2/payments/list`                 | `getListPaymentV2`          | `PaymentsListV2`          | `TransactionArrayResponse`   |
| `chargebacks/list`                 | `chargebacksList`           | `ChargebacksList`         | `ChargebackArrayResponse`    |
| `payments/qr/sbp/link`             | `paymentsQrSbpLink`         | `SbpLink`                 | `QrLinkResponse`             |
| `payments/qr/sbp/image`            | `paymentsQrSbpImage`        | `SbpLink`                 | `QrLinkResponse`             |
| `sbp/v2/banks/info`                | `sbpV2BanksInfo`            | `SbpBanksInfo` или `null` | `SbpBanksInfoResponse`       |
| `payments/tokens/list`             | `paymentsTokensList`        | `TokenList` или `null`    | `TokenArrayResponse`         |
| `subscriptions/create`             | `subscriptionsCreate`       | `SubscriptionCreate`      | `SubscriptionResponse`       |
| `subscriptions/get`                | `subscriptionsGet`          | `SubscriptionGet`         | `SubscriptionResponse`       |
| `subscriptions/find`               | `subscriptionsFind`         | `SubscriptionFind`        | `SubscriptionArrayResponse`  |
| `subscriptions/update`             | `subscriptionsUpdate`       | `SubscriptionUpdate`      | `SubscriptionResponse`       |
| `subscriptions/cancel`             | `subscriptionsCancel`       | `SubscriptionCancel`      | `CloudResponse`              |
| `orders/create`                    | `ordersCreate`              | `OrderCreate`             | `OrderResponse`              |
| `orders/cancel`                    | `ordersCancel`              | `OrderCancel`             | `CloudResponse`              |
| `site/notifications/{Type}/get`    | `siteNotificationsGet`      | `NotificationsGet`        | `NotificationResponse`       |
| `site/notifications/{Type}/update` | `siteNotificationsUpdate`   | `NotificationsUpdate`     | `CloudResponse`              |
| `applepay/startsession`            | `startSession`              | `ApplepayStartSession`    | `AppleSessionResponse`       |
| `kkt/receipt`                      | `createReceipt`             | `KktReceipt`              | `KktReceiptResponse`         |
| `test`                             | `test`                      | —                         | `CloudResponse`              |

`payments/find` сохраняется для обратной совместимости. `v2/payments/find` ищет последнюю операцию среди платежей, возвратов и выплат на карту.

`payments/list` выгружает операции за один день. `v2/payments/list` выгружает операции за произвольный период, использует пагинацию и необязательный фильтр статусов. `pageNumber` начинается с 1, одна страница содержит не более 100 операций. Порядок ответа сохраняется библиотекой.

`chargebacks/list` выгружает претензии за период не больше одного календарного года. `pageNumber` начинается с 1, одна страница содержит не более 100 претензий. Библиотека сохраняет порядок ответа CloudPayments. Поле `ErrorCode` доступно через `$response->errorCode`.

## Запросы

Параметры API передаются через DTO из namespace `Excent\Cloudpayments\Request`.

```php
use Excent\Cloudpayments\Request\ApplepayStartSession;

$request = new ApplepayStartSession(
    'https://apple-pay-gateway.apple.com/paymentservices/startSession'
);

$response = $client->startSession($request);
```

DTO наследуются от `BaseRequest` и преобразуются в формат CloudPayments через `asArray()`:

- `amount` превращается в `Amount`;
- значения `null` не попадают в запрос;
- `true` и `false` в полях Request DTO передаются как строковые значения, ожидаемые API;
- вложенные DTO и массивы DTO преобразуются рекурсивно.

Для структурированных данных `JsonData` можно использовать общий DTO `CloudpaymentsData`. Он добавляет обязательную для CloudPayments обёртку `cloudpayments` и переиспользует `CustomerReceipt` во всех платежных методах, поддерживающих `JsonData`:

```php
use Excent\Cloudpayments\Enum\Currency;
use Excent\Cloudpayments\Enum\SbpScheme;
use Excent\Cloudpayments\Request\SbpLink;
use Excent\Cloudpayments\Request\CloudpaymentsData;
use Excent\Cloudpayments\Request\Receipt\CustomerReceipt;
use Excent\Cloudpayments\Request\Receipt\ReceiptItem;

$jsonData = new CloudpaymentsData(
    customerReceipt: new CustomerReceipt([
        new ReceiptItem('Товар', '100.00', '1.00', '100.00'),
    ]),
    additionalData: ['name' => 'Покупатель'],
);

$request = new SbpLink(
    '1000.00',
    Currency::RUB,
    SbpScheme::CHARGE,
    jsonData: $jsonData,
);
```

Для `SbpLink` используются типизированные enum-поля `Currency::RUB`, `SbpScheme::CHARGE` и `Device`. Поля `Os` и `Browser` остаются строковыми, поскольку API допускает новые значения. Поле `jsonData` принимает только `CloudpaymentsData`; для существующих DTO со строковым `JsonData` используется `$jsonData->asJson()`.

`CustomerReceipt` является общим DTO для чеков и не привязан к СБП. Вложенные реквизиты представлены DTO `UserRequisiteData`, `OperationReceiptRequisite`, `IndustryRequisiteCollection[]` и `NonCashPayments[]`; `RussiaTimeZone` принимает RTZ enum-коды `1–11`.

Некоторые DTO для совместимости с существующим публичным контрактом заполняются через публичные свойства:

```php
use Excent\Cloudpayments\Request\NotificationsUpdate;

$request = new NotificationsUpdate();
$request->type = 'pay';
$request->isEnabled = true;
$request->address = 'https://example.com/cloudpayments/pay';

$client->siteNotificationsUpdate($request);
```

## Ответы

Все response DTO наследуются от `CloudResponse`.

| Свойство    | Описание                                         |
|-------------|--------------------------------------------------|
| `success`   | Результат операции из поля `Success`.            |
| `message`   | Сообщение из поля `Message`.                     |
| `warning`   | Предупреждение из поля `Warning`.                |
| `errorCode` | Код ошибки из поля `ErrorCode`.                  |
| `model`     | Модель ответа, тип зависит от вызванного метода. |

Поддерживаемые модели:

| Response DTO                 | Model                     |
|------------------------------|---------------------------|
| `AppleSessionResponse`       | `AppleSessionModel`       |
| `ChargebackArrayResponse`    | `ChargebackModel[]`       |
| `KktReceiptResponse`         | `KktReceiptModel`         |
| `NotificationResponse`       | `NotificationModel`       |
| `OrderResponse`              | `OrderModel`              |
| `QrLinkResponse`             | `QrLinkModel`             |
| `SbpBanksInfoResponse`       | `SbpBanksInfoModel[]`     |
| `SubscriptionResponse`       | `SubscriptionModel`       |
| `SubscriptionArrayResponse`  | `SubscriptionModel[]`     |
| `TokenArrayResponse`         | `TokenModel[]`            |
| `TransactionResponse`        | `TransactionModel`        |
| `TransactionArrayResponse`   | `TransactionModel[]`      |
| `TransactionWith3dsResponse` | `TransactionWith3dsModel` |

`SbpBanksInfoResponse` содержит массив источников (`SbpBanksInfoModel`), а `members` каждого источника — типизированный массив банков (`SbpBankMemberModel`). Библиотека сохраняет исходный порядок источников и банков и не изменяет значения `name`, `logo` и `url`.

Для `paymentsQrSbpImage` значение `model->qrImage` содержит PNG-код, закодированный в Base64, и возвращается библиотекой без декодирования. Значение `model->qrUrl` для этого метода равно `null`. Один QR-код СБП можно использовать для многократной оплаты.

Если CloudPayments вернет поля, которых нет в модели, они будут доступны через `getAdditionalProperties()`.

```php
$extra = $response->model->getAdditionalProperties();
```

## Уведомления

Библиотека включает DTO для данных webhook-уведомлений. Классы мапят поля CloudPayments вида `TransactionId` в свойства вида `transactionId`.

```php
use Excent\Cloudpayments\Hook\HookPay;

$hook = new HookPay($_POST);

echo $hook->transactionId;
```

Классы уведомлений:

| Webhook     | DTO             |
|-------------|-----------------|
| `Check`     | `HookCheck`     |
| `Pay`       | `HookPay`       |
| `Fail`      | `HookFail`      |
| `Confirm`   | `HookConfirm`   |
| `Refund`    | `HookRefund`    |
| `Recurrent` | `HookRecurrent` |
| `Cancel`    | `HookCancel`    |
| `Receipt`   | `HookReceipt`   |

Webhook DTO только преобразуют входные данные в объект. Проверку подписи, бизнес-валидацию и формирование ответа для CloudPayments нужно реализовать на стороне приложения.

## Идемпотентность

Для идемпотентных запросов библиотека отправляет заголовок `X-Request-ID`.

Автоматический ключ строится из метода и данных запроса:

```php
$client->setIdempotency(true);

$response = $client->createPaymentByCard2Step($request);
```

Можно задать ключ явно:

```php
$client->setIdempotencyKey('order-100500-auth');

$response = $client->createPaymentByCard2Step($request);
```

## Обработка ошибок

Методы `Library` объявляют `@throws Throwable` и передают исходные исключения и ошибки вызывающему коду без обёрток.

| Тип исключения | Причина |
|----------------|---------|
| `BadTypeException` | Некорректные параметры request DTO. |
| `GuzzleException` | Ошибка соединения или HTTP-запроса. |
| `JsonException` | Ошибка сериализации или разбора JSON. |
| `ResponseFormatException` | Некорректная модель транзакции, включая `TransactionId`. |

`BadTypeException` и `ResponseFormatException` наследуют `CloudpaymentsException`. Ответ с `Success: false` не является исключением: проверяйте `success`, `message` и `errorCode`.

```php
use Excent\Cloudpayments\Request\PaymentsRefund;

try {
    $request = new PaymentsRefund($transactionId, $amount);
    $response = $client->paymentsRefund($request);

    if (! $response->success) {
        // API отклонил операцию: проверьте message и errorCode.
    }
} catch (\Throwable $error) {
    // Обработайте или зарегистрируйте исходную ошибку вызова.
}
```

### TransactionId

Модели транзакций предоставляют точный `transactionId` типа PHP `int`. SDK принимает целые числа и знаковые десятичные строки в диапазоне `PHP_INT_MIN`–`PHP_INT_MAX`, сохраняя точность целых чисел из JSON. Отсутствующие, некорректные и выходящие за диапазон ID вызывают `ResponseFormatException`.

Проверка выполняется и при `Success: false`, если ответ содержит модель, в том числе при отказе платежа и 3-D Secure. Ответы подтверждения и отмены оплаты без `Model` допустимы. При ручном создании модели передайте данные: `new TransactionModel((object) ['TransactionId' => 123])`.

## Версионирование

История релизов и инструкции по миграции — в [CHANGELOG.md](CHANGELOG.md).

## License

MIT. See [LICENSE](LICENSE).

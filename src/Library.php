<?php

namespace Excent\Cloudpayments;

use Excent\Cloudpayments\Enum\CloudMethodsEnum;
use Excent\Cloudpayments\Request\ApplepayStartSession;
use Excent\Cloudpayments\Request\CardsPayment;
use Excent\Cloudpayments\Request\CardsTopUp;
use Excent\Cloudpayments\Request\KktReceipt;
use Excent\Cloudpayments\Request\NotificationsGet;
use Excent\Cloudpayments\Request\NotificationsUpdate;
use Excent\Cloudpayments\Request\OrderCancel;
use Excent\Cloudpayments\Request\OrderCreate;
use Excent\Cloudpayments\Request\PaymentsConfirm;
use Excent\Cloudpayments\Request\PaymentsFind;
use Excent\Cloudpayments\Request\PaymentsGet;
use Excent\Cloudpayments\Request\PaymentsList;
use Excent\Cloudpayments\Request\PaymentsRefund;
use Excent\Cloudpayments\Request\PaymentsVoid;
use Excent\Cloudpayments\Request\Post3DS;
use Excent\Cloudpayments\Request\SubscriptionCancel;
use Excent\Cloudpayments\Request\SubscriptionCreate;
use Excent\Cloudpayments\Request\SubscriptionFind;
use Excent\Cloudpayments\Request\SubscriptionGet;
use Excent\Cloudpayments\Request\SubscriptionUpdate;
use Excent\Cloudpayments\Request\TokenList;
use Excent\Cloudpayments\Request\TokenPayment;
use Excent\Cloudpayments\Request\TokenTopUp;
use Excent\Cloudpayments\Response\AppleSessionResponse;
use Excent\Cloudpayments\Response\CloudResponse;
use Excent\Cloudpayments\Response\KktReceiptResponse;
use Excent\Cloudpayments\Response\NotificationResponse;
use Excent\Cloudpayments\Response\OrderResponse;
use Excent\Cloudpayments\Response\SubscriptionArrayResponse;
use Excent\Cloudpayments\Response\SubscriptionResponse;
use Excent\Cloudpayments\Response\TokenArrayResponse;
use Excent\Cloudpayments\Response\TransactionArrayResponse;
use Excent\Cloudpayments\Response\TransactionResponse;
use Excent\Cloudpayments\Response\TransactionWith3dsResponse;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Библиотека методов для работы с CloudPayments
 * Class Library.
 */
class Library
{
    final public const DEFAULT_URL = 'https://api.cloudpayments.ru/';
    protected string $url;
    protected Client $client;
    protected bool $idempotency = false;
    protected ?string $idempotencyKey = null;

    public function __construct(protected string $publicId, protected string $pass, ?string $cpUrlApi = null)
    {
        $this->url = $cpUrlApi ?? self::DEFAULT_URL;

        $this->client = new Client([
            'base_uri' => $this->url,
            'auth' => [
                $this->publicId,
                $this->pass,
            ],
            'expect' => false,
        ]);
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setIdempotency(bool $idempotency): void
    {
        $this->idempotency = $idempotency;
    }

    /**
     * Кастомный ключ идемпотентности.
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->setIdempotency(true);
        $this->idempotencyKey = $idempotencyKey;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Проверка платежа по номеру заказа.
     */
    public function getPaymentDataByInvoice(PaymentsFind $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_FIND;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Метод получения детализации по транзакции.
     *
     * @return TransactionResponse
     */
    public function getPaymentData(PaymentsGet $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_GET;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Создание оплаты по токену при двухшаговой оплате.
     *
     * @return TransactionResponse
     */
    public function createPaymentByToken2Step(TokenPayment $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_TOKENS_AUTH;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Создание оплаты по карте при двухшаговой оплате.
     *
     * @return TransactionWith3dsResponse
     */
    public function createPaymentByCard2Step(CardsPayment $data): TransactionWith3dsResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_CARDS_AUTH;

        return $this->request($method, $data->asArray(), new TransactionWith3dsResponse());
    }

    /**
     * обработка 3Ds.
     */
    public function post3Ds(Post3DS $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_CARDS_POST3DS;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Проведение оплаты по токену при одношаговой оплате.
     *
     * @return TransactionResponse
     */
    public function executePaymentByToken(TokenPayment $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_TOKENS_CHARGE;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Подтверждение оплаты.
     *
     * @return CloudResponse
     */
    public function confirmPayment(PaymentsConfirm $data): CloudResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_CONFIRM;

        return $this->request($method, $data->asArray());
    }

    /**
     * Список транзакций за определенное время.
     *
     * @return TransactionArrayResponse
     */
    public function getListPayment(PaymentsList $data): TransactionArrayResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_LIST;

        return $this->request($method, $data->asArray(), new TransactionArrayResponse());
    }

    /**
     * Отмена оплаты.
     *
     * @return CloudResponse
     */
    public function cancelPayment(PaymentsVoid $data): CloudResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_VOID;

        return $this->request($method, $data->asArray());
    }

    /**
     * Старт сессии Applepay.
     *
     * @return AppleSessionResponse
     */
    public function startSession(ApplepayStartSession $data): AppleSessionResponse
    {
        $method = CloudMethodsEnum::APPLEPAY_STARTSESSION;

        return $this->request($method, $data->asArray(), new AppleSessionResponse());
    }

    /**
     * Создание чека.
     *
     * @return KktReceiptResponse
     */
    public function createReceipt(KktReceipt $data): KktReceiptResponse
    {
        $method = CloudMethodsEnum::KKT_RECEIPT;

        return $this->request($method, $data->asArray(), new KktReceiptResponse());
    }

    /**
     * Возврат средств.
     *
     * @return TransactionResponse
     */
    public function paymentsRefund(PaymentsRefund $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_REFUND;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Метод для оплаты по криптограмме платежных данных (результат алгоритма шифрования)
     * для одностадийного платежа.
     *
     * @return TransactionWith3dsResponse
     */
    public function paymentsCardsCharge(CardsPayment $data): TransactionWith3dsResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_CARDS_CHARGE;

        return $this->request($method, $data->asArray(), new TransactionWith3dsResponse());
    }

    /**
     * Выплата по криптограмме.
     *
     * @return TransactionResponse
     */
    public function paymentsCardsTopup(CardsTopUp $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_CARDS_TOPUP;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Выплата по токену.
     *
     * @return TransactionResponse
     */
    public function paymentsTokenTopup(TokenTopUp $data): TransactionResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_TOKEN_TOPUP;

        return $this->request($method, $data->asArray(), new TransactionResponse());
    }

    /**
     * Метод выгрузки списка всех платежных токенов CloudPayments.
     *
     * @param  TokenList|null  $data
     * @return TokenArrayResponse
     */
    public function paymentsTokensList(?TokenList $data = null): TokenArrayResponse
    {
        $method = CloudMethodsEnum::PAYMENTS_TOKENS_LIST;

        return $this->request($method, $data === null ? [] : $data->asArray(), new TokenArrayResponse());
    }

    /**
     * Метод создания подписки на рекуррентные платежи.
     *
     * @return SubscriptionResponse
     */
    public function subscriptionsCreate(SubscriptionCreate $data): SubscriptionResponse
    {
        $method = CloudMethodsEnum::SUBSCRIPTIONS_CREATE;

        return $this->request($method, $data->asArray(), new SubscriptionResponse());
    }

    /**
     * Метод получения информации о статусе подписки.
     *
     * @return SubscriptionResponse
     */
    public function subscriptionsGet(SubscriptionGet $data): SubscriptionResponse
    {
        $method = CloudMethodsEnum::SUBSCRIPTIONS_GET;

        return $this->request($method, $data->asArray(), new SubscriptionResponse());
    }

    /**
     * Метод получения списка подписок для определенного аккаунта.
     *
     * @return SubscriptionArrayResponse
     */
    public function subscriptionsFind(SubscriptionFind $data): SubscriptionArrayResponse
    {
        $method = CloudMethodsEnum::SUBSCRIPTIONS_FIND;

        return $this->request($method, $data->asArray(), new SubscriptionArrayResponse());
    }

    /**
     * Метод изменения ранее созданной подписки.
     *
     * @return SubscriptionResponse
     */
    public function subscriptionsUpdate(SubscriptionUpdate $data): SubscriptionResponse
    {
        $method = CloudMethodsEnum::SUBSCRIPTIONS_UPDATE;

        return $this->request($method, $data->asArray(), new SubscriptionResponse());
    }

    /**
     * Метод отмены подписки на рекуррентные платежи.
     *
     * @return CloudResponse
     */
    public function subscriptionsCancel(SubscriptionCancel $data): CloudResponse
    {
        $method = CloudMethodsEnum::SUBSCRIPTIONS_CANCEL;

        return $this->request($method, $data->asArray());
    }

    /**
     * Создание счета для отправки по почте.
     *
     * @return OrderResponse
     */
    public function ordersCreate(OrderCreate $data): OrderResponse
    {
        $method = CloudMethodsEnum::ORDERS_CREATE;

        return $this->request($method, $data->asArray(), new OrderResponse());
    }

    /**
     * Метод отмены созданного счета.
     *
     * @return CloudResponse
     */
    public function ordersCancel(OrderCancel $data): CloudResponse
    {
        $method = CloudMethodsEnum::ORDERS_CANCEL;

        return $this->request($method, $data->asArray());
    }

    /**
     * Метод просмотра настроек уведомлений (с указанием типа уведомления).
     */
    public function siteNotificationsGet(NotificationsGet $data): NotificationResponse
    {
        $method = sprintf('site/notifications/%s/get', $data->type);

        return $this->request($method, $data->asArray(), new NotificationResponse());
    }

    /**
     * Метод изменения настроек уведомлений.
     */
    public function siteNotificationsUpdate(NotificationsUpdate $data): CloudResponse
    {
        $method = sprintf('site/notifications/%s/update', $data->type);

        return $this->request($method, $data->asArray());
    }

    /**
     * Базовый запрос
     */
    private function request(
        string $method,
        array $postData = [],
        ?CloudResponse $cloudResponse = null
    ): CloudResponse {
        $response = $this->sendRequest($method, $postData);

        $cloudResponse ??= new CloudResponse();

        return $cloudResponse->fillByResponse($response);
    }

    /**
     * Запрос по api.
     */
    public function sendRequest(string $method, array $postData = []): ResponseInterface
    {
        $options = ['form_params' => $postData];

        if ($this->idempotency) {
            $options['headers'] = ['X-Request-ID' => $this->idempotencyKey ?? $this->getRequestId($method, $postData)];
        }

        return $this->client->post('/' . $method, $options);
    }

    /**
     * Генерирует request id для идемпотентных запросов.
     */
    public function getRequestId(string $method, array $postData): string
    {
        $stringData = "method:$method;";

        foreach ($postData as $key => $value) {
            $stringData .= sprintf('%s:%s', $key, serialize($value));
        }

        return md5($stringData);
    }
}

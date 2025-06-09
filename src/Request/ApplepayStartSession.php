<?php

namespace Excent\Cloudpayments\Request;

use Excent\Cloudpayments\Exceptions\BadTypeException;

/**
 * @see     https://developers.cloudpayments.ru/#zapusk-sessii-dlya-oplaty-cherez-apple-pay
 */
class ApplepayStartSession extends BaseRequest
{
    /**
     * @throws BadTypeException
     */
    public function __construct(
        public string $validationUrl,
        public ?string $paymentUrl = null
    ) {
        if (filter_var($validationUrl, FILTER_VALIDATE_URL) === false) {
            throw new BadTypeException('Validation url is wrong');
        }

        if ($paymentUrl !== null) {
            if (filter_var($paymentUrl, FILTER_VALIDATE_URL) === false) {
                throw new BadTypeException('Payment url is wrong');
            }
        }
    }
}

<?php

namespace Excent\Cloudpayments\Request;

/**
 * Class PaymentsList.
 *
 * @see     https://developers.cloudpayments.ru/#vygruzka-spiska-tranzaktsiy
 */
class PaymentsList extends BaseRequest
{
    /**
     * https://developers.cloudpayments.ru/#kody-vremennyh-zon.
     * @var string
     */
    public string $timeZone;

    public function __construct(/**
     * "Date":"2014-08-09".
     */
        public string $date,
        ?string $timeZone = null
    ) {
        if ($timeZone) {
            $this->timeZone = $timeZone;
        }
    }
}

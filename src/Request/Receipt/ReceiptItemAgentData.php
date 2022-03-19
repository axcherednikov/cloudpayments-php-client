<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#agentdata
 */
class ReceiptItemAgentData extends BaseRequest
{
    public ?string $agentOperationName = null;
    public ?string $paymentAgentPhone = null;
    public ?string $paymentReceiverOperatorPhone = null;
    public ?string $transferOperatorPhone = null;
    public ?string $transferOperatorName = null;
    public ?string $transferOperatorAddress = null;
    public ?string $transferOperatorInn = null;
}

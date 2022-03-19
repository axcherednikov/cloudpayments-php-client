<?php

namespace Excent\Cloudpayments\Request\Receipt;

use Excent\Cloudpayments\BaseRequest;

/**
 * @see https://developers.cloudkassir.ru/#purveyordata
 */
class ReceiptItemPurveyorData extends BaseRequest
{
    public string $name;
    public string $inn;
    public ?string $phone = null;

    /**
     * @param  string  $name
     * @param  string  $inn
     */
    public function __construct(string $name, string $inn)
    {
        $this->name = $name;
        $this->inn = $inn;
    }
}

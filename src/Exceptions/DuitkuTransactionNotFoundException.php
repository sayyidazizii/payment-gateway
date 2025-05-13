<?php

namespace Sayyidzaizii\Duitku\Exceptions;

/**
 * Class DuitkuTransactionNotFoundException
 * @package Sayyidzaizii\Duitku\Exceptions
 */
class DuitkuTransactionNotFoundException extends \Exception
{
    protected $message = 'Transaction not found.';

    public function __construct(string $orderId)
    {
        parent::__construct("Transaction not found for Order ID: $orderId", $this->getCode(), $this->getPrevious());
    }
}

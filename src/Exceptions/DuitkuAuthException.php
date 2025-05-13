<?php

namespace Sayyidaizii\Duitku\Exceptions;

/**
 * Class DuitkuAuthException
 * @package Sayyidaizii\Duitku\Exceptions
 */
class DuitkuAuthException extends \Exception
{
    protected $message = 'Authentication to Duitku failed, make sure you set the right Merchant Code and API Key.';
}

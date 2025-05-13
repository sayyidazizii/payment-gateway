<?php

namespace Sayyidzaizii\Duitku\Enums;

/**
 * Class DuitkuPaymentCode
 * ref: https://docs.duitku.com/api/id/#result-code-redirect
 * @package Sayyidzaizii\Duitku\Enums
 */
abstract class DuitkuPaymentCode
{
    const SUCCESS = "00";
    const PENDING = "01";
    const FAILED = "02"; // Canceled/failed
}

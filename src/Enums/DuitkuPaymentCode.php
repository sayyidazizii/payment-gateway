<?php

namespace Sayyidaizii\Duitku\Enums;

/**
 * Class DuitkuPaymentCode
 * ref: https://docs.duitku.com/api/id/#result-code-redirect
 * @package Sayyidaizii\Duitku\Enums
 */
abstract class DuitkuPaymentCode
{
    const SUCCESS = "00";
    const PENDING = "01";
    const FAILED = "02"; // Canceled/failed
}

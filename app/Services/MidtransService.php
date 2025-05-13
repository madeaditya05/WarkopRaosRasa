<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public static function init()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public static function createTransaction($payload)
    {
        self::init();
        return Snap::createTransaction($payload);
    }
}

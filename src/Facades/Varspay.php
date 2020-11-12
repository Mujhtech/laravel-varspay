<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Mujtech Mujeeb <mujeeb.muhideen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mujhtech\Varspay\Facades;

use Illuminate\Support\Facades\Facade;

class Varspay extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-varspay';
    }
}
<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack\Api\Concerns;

use MusheAbdulHakim\Paystack\Contracts\TransporterContract;

trait Transportable
{
    public function __construct(private readonly TransporterContract $transporter)
    {
        // ..
    }
}

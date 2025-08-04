<?php

declare(strict_types=1);

namespace MusheAbdulHakim\CoinGecko\Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}

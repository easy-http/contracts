<?php

namespace EasyHTTP\Contracts\Tests;

use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();

        parent::setUp();
    }
}

<?php

namespace Tests;

abstract class DatabaseTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }
}

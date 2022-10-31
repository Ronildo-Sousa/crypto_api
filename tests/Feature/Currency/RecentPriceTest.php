<?php

namespace Tests\Feature\Currency;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\HttpTestBase;


class RecentPriceTest extends HttpTestBase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        dd($this->get("/"));
    }
}

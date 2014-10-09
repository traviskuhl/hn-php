<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\PollOpt
;

class PollOptTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testProperties() {
        $s = new PollOpt($this->client);

        $props = [
            'by',
            'id',
            'parent',
            'score',
            'text',
            'time',
            'type'
        ];

        foreach ($props as $name) {
            $this->assertTrue(property_exists($s, $name));
        }

    }

}
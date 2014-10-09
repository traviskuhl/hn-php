<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\Story
;

class StoryTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testProperties() {
        $s = new Story($this->client);

        $props = [
            'by',
            'id',
            'kids',
            'score',
            'time',
            'title',
            'url'
        ];

        foreach ($props as $name) {
            $this->assertTrue(property_exists($s, $name));
        }

    }

}
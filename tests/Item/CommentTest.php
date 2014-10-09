<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\Comment
;

class CommentTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testProperties() {
        $c = new Comment($this->client);

        $props = [
            'by',
            'id',
            'kids',
            'parent',
            'text',
            'time'
        ];

        foreach ($props as $name) {
            $this->assertTrue(property_exists($c, $name));
        }

    }

}
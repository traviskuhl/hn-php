<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\Poll
;

class PollTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testProperties() {
        $s = new Poll($this->client);

        $props = [
            'by',
            'id',
            'kids',
            'parts',
            'score',
            'text',
            'time',
            'title'
        ];

        foreach ($props as $name) {
            $this->assertTrue(property_exists($s, $name));
        }

    }

    public function testParts() {
        $p = new Poll($this->client, ['parts' => ['test']]);

        $this->setMock($this->client, 200, 'item-pollopt');
        $result = $p->parts();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('hn\Item\PollOpt', array_shift($result));

    }


}
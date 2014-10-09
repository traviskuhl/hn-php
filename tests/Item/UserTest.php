<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\User
;

class UserTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testProperties() {
        $s = new User($this->client);

        $props = [
            'about',
            'created',
            'delay',
            'id',
            'karma',
            'submitted'
        ];

        foreach ($props as $name) {
            $this->assertTrue(property_exists($s, $name));
        }

    }

    public function testParts() {
        $p = new User($this->client, ['submitted' => ['test']]);

        $this->setMock($this->client, 200, 'item-story');
        $result = $p->submitted();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('hn\Item\Story', array_shift($result));

    }


}
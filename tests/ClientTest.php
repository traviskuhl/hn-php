<?php

namespace hn\Tests;
use hn\Client;

class ClientTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testExtendsGuzzleClient() {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->client);
    }

    public function testItemStory() {
        $result = $this
            ->setMock($this->client, 200, 'item-story')
            ->item('test');
        $this->assertInstanceOf('hn\Item\Story', $result);
    }

    public function testItemComment() {
        $result = $this
            ->setMock($this->client, 200, 'item-comment')
            ->item('test');
        $this->assertInstanceOf('hn\Item\Comment', $result);
    }

    public function testItemPoll() {
        $result = $this
            ->setMock($this->client, 200, 'item-poll')
            ->item('test');
        $this->assertInstanceOf('hn\Item\Poll', $result);
    }

    public function testItemPollOpt() {
        $result = $this
            ->setMock($this->client, 200, 'item-pollopt')
            ->item('test');
        $this->assertInstanceOf('hn\Item\PollOpt', $result);
    }

}
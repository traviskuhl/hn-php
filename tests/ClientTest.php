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

    public function testUser() {
        $result = $this
            ->setMock($this->client, 200, 'user')
            ->user('test');
        $this->assertInstanceOf('hn\Item\User', $result);
    }

    public function testTopStories() {
        $result = $this
            ->setMock($this->client, 200, 'top-stories')
            ->topStories();
        $this->assertTrue(is_array($result));
        $this->assertEquals($result[0], 8414149);
    }

    public function testMaxItem() {
        $result = $this
            ->setMock($this->client, 200, 'max-id')
            ->maxItem();
        $this->assertEquals($result, 8423374);
    }

    public function testUpdates() {
        $result = $this
            ->setMock($this->client, 200, 'updates')
            ->updates();
        $this->assertTrue(is_array($result));
        $this->assertTrue(array_key_exists('items', $result));
        $this->assertTrue(array_key_exists('profiles', $result));
        $this->assertEquals($result['items'][0], 8423305);
        $this->assertEquals($result['profiles'][0], 'thefox');

    }

}
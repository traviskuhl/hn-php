<?php

namespace hn\Tests\Item;

use
    hn\Tests\Test,
    hn\Client,
    hn\Item\AbstractItem
;

class AbastractItemTest extends Test {

    private $client;

    public function setUp() {
        $this->client = new Client();
    }

    public function testSetData() {
        $a = new AbstractItemTest_Test($this->client);

        $data = [
            'testData1' => 'test1',
            'testData2' => 'test2'
        ];

        $this->assertEquals($a, $a->setData($data));

        $this->assertEquals($a->testData1, 'test1');
        $this->assertEquals($a->testData2, 'test2');

    }

    public function testByNoByProperty() {
        $this->setExpectedException('hn\Exception\PropertyException');
        $a = new AbstractItemTest_Test($this->client);
        $a->by();
    }

    public function testKidsNoKidsProperty() {
        $this->setExpectedException('hn\Exception\PropertyException');
        $a = new AbstractItemTest_Test($this->client);
        $a->kids();
    }

    public function testDateTimeNoTimeProperty() {
        $this->setExpectedException('hn\Exception\PropertyException');
        $a = new AbstractItemTest_Test($this->client);
        $a->datetime();
    }

    public function testChildrenNoProperty() {
        $this->setExpectedException('hn\Exception\PropertyException');
        $a = new AbstractItemTest_Test($this->client);
        $a->children('not');
    }

    public function testBy() {
        $a = new AbstractItemTest_TestWithProperties($this->client);
        $this->setMock($this->client, 200, 'user');
        $result = $a->by();
        $this->assertInstanceOf('hn\Item\User', $result);
    }

    public function testKids() {
        $a = new AbstractItemTest_TestWithProperties($this->client);
        $this->setMock($this->client, 200, 'item-story');
        $result = $a->kids();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('hn\Item\Story', array_shift($result));

    }

    public function testDatetime() {
        $a = new AbstractItemTest_TestWithProperties($this->client);
        $dt = new \DateTime('@1412813133');
        $this->assertEquals($dt, $a->datetime());
    }

    public function testChildren() {
        $a = new AbstractItemTest_TestWithProperties($this->client);
        $this->setMock($this->client, 200, 'item-poll');
        $result = $a->children('kids');
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('hn\Item\Poll', array_shift($result));
    }

}


class AbstractItemTest_Test extends AbstractItem {

    public $testData1;
    public $testData2;

}

class AbstractItemTest_TestWithProperties extends AbstractItem {

    public $by = 'test';
    public $kids = ['test'];
    public $time = 1412813133;

}
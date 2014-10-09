<?php

namespace hn\Item;

use hn\Client,
    hn\Exception\PropertyException
;

abstract class AbstractItem {

    /**
     * @var hn\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param hn\Client $client
     * @param array $data
     *
     */
    public function __construct(Client $client, array $data = []) {
        $this->client = $client;
        if ($data) {
            $this->setData($data);
        }
    }

    /**
     * set data for the item
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * return a user object if this item has a 'by' property
     *
     * @return hn\Item\User
     */
    public function by() {
        if (!property_exists($this, 'by')) {
            throw new PropertyException("Item does not have 'by' property.");
        }
        return $this->client->user($this->by);
    }


    /**
     * return child objects for the provided slice
     *
     * @param  integer $limit
     * @param  integer $offset
     *
     * @return array
     */
    public function kids($limit = 10, $offset = 0) {
        if (!property_exists($this, 'kids')) {
            throw new PropertyException("Item does not have 'kids' property.");
        }
        return $this->children('kids', $limit, $offset);
    }


    /**
     * return a DataTime object fo ths properties time
     *
     * @return DateTime
     */
    public function datetime() {
        if (!property_exists($this, 'time')) {
            throw new PropertyException("Item does not have 'time' property.");
        }
        $dt = new \DateTime();
        $dt->setTimestamp($this->time);
        return $dt;
    }


    /**
     * return a slice of child items for given field
     *
     * @param  string  $field
     * @param  integer $limit
     * @param  integer $offset
     *
     * @return array
     */
    public function children($field, $limit = 10, $offset = 0) {
        if (!property_exists($this, $field)) {
            throw new PropertyException("Item does not have '{$field}' property.");
        }
        $reqs = [];

        foreach(array_slice($this->{$field}, $offset, $limit) as $id) {
            $reqs[$id] = $this->client->createRequest('GET', "item/{$id}.json");
        }

        return $this->client->batch($reqs);

    }

}
<?php

namespace hn\Item;

use hn\Client,
    hn\Exception\PropertyException
;

abstract class AbstractItem {

    protected $client;

    public function __construct(Client $client, array $data = []) {
        $this->client = $client;
        if ($data) {
            $this->setData($data);
        }
    }

    public function setData(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }


    public function by() {
        if (!property_exists($this, 'by')) {
            throw new PropertyException("Item does not have 'by' property.");
        }
        return $this->client->user($this->by);
    }

    public function kids($limit = 10, $offset = 0) {
        if (!property_exists($this, 'kids')) {
            throw new PropertyException("Item does not have 'kids' property.");
        }
        return $this->children('kids', $limit, $offset);
    }

    public function datetime() {
        if (!property_exists($this, 'time')) {
            throw new PropertyException("Item does not have 'time' property.");
        }
        return new \DateTime($this->time);
    }

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
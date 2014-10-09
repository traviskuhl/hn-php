<?php

namespace hn\Item;

class User extends AbstractItem {

    public $about;
    public $created;
    public $delay;
    public $id;
    public $karma;
    public $submitted;

    public function submitted($limit = 10, $offset = 0) {
        return $this->children('submitted', $limit, $offset);
    }

}

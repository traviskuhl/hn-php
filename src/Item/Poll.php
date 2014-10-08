<?php

namespace hn\Item;

class Poll extends AbstractItem {

    public $by;
    public $id;
    public $kids;
    public $parts;
    public $score;
    public $text;
    public $time;
    public $title;

    public function parts($limit = 10, $offset = 0) {
        return $this->children('parts', $limit, $offset);
    }

}
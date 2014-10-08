<?php

namespace hn;

use GuzzleHttp\Client as GuzzleClient,
    GuzzleHttp\Exception\RequestException,

    hn\Exception\ResponseException
;


class Client extends GuzzleClient {

    const API_BASE_URL = "https://hacker-news.firebaseio.com";
    const API_VERSION = "v0";

    public function __construct() {
        parent::__construct([
                'base_url' => implode("/", [self::API_BASE_URL, self::API_VERSION])
            ]);
    }

    public function item($id) {

        try {
            $result = $this->get("item/{$id}.json")
                ->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return $this->response($result);

    }

    protected function response($result) {
        switch($result['type']) {
            case 'story':
                return new Item\Story($this, $result);

            case 'comment':
                return new Item\Comment($this, $result);

            case 'poll':
                return new Item\Poll($this, $result);

            case 'pollopt':
                return new Item\PollOpt($this, $result);

            default:
                throw new ResponseException();
        };
    }

    public function user($id) {

        try {
            $result = $this->get("user/{$id}.json");
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return new Item\User($this, $result);

    }

    public function topStories() {

        try {
            $result = $this->get("topstories.json")
                ->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }


    }

    public function maxItem() {

    }

    public function updates() {

    }

}
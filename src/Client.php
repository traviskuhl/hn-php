<?php

namespace hn;

use GuzzleHttp,
    GuzzleHttp\Client as GuzzleClient,
    GuzzleHttp\Exception\RequestException,

    hn\Exception\ResponseException
;

/**
 * Hacker News PHP Client
 */
class Client extends GuzzleClient {

    /**
     * api base url
     */
    const API_BASE_URL = "https://hacker-news.firebaseio.com";

    /**
     * api version to use
     * @var string
     */
    private $version =  "v0";


    /**
     * Constructor
     *
     * @param string $version version number (v0)
     */
    public function __construct($version = null) {
        if ($version) {
            $this->version = $version;
        }

        parent::__construct([
                'base_url' => implode("/", [self::API_BASE_URL, $this->version])
            ]);
    }


    /**
     * request an item by id
     *
     * @param  int $id item id
     *
     * @return mixed
     */
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

    /**
     * return the correct item type based
     * on api result
     *
     * @param  array $result
     *
     * @return mixed
     */
    protected function response(array $result) {
        if (!array_key_exists('type', $result)) {
            throw new ResponseException("No 'type' key in result");
        }

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
                throw new ResponseException("Unknown result type. Must be one of 'story', 'comment', 'poll', 'pollopt'.");
        };
    }


    /**
     * request a user object by id
     *
     * @param  int $id user id
     *
     * @return hn\Item\User
     */
    public function user($id) {

        try {
            $result = $this->get("user/{$id}.json")->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return new Item\User($this, $result);

    }


    /**
     * request a list of top story ids
     *
     * @return array
     */
    public function topStories() {

        try {
            $result = $this->get("topstories.json")
                ->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return $result;
    }


    /**
     * request the max item id
     *
     * @return int
     */
    public function maxItem() {
        try {
            $result = $this->get("maxitem.json")
                ->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return (int)$result;
    }


    /**
     * request a list of updates for items and users
     *
     * @return array
     */
    public function updates() {
        try {
            $result = $this->get("updates.json")
                ->json();
        }
        catch (RequestException $e) {
            throw new Exception\RequestException();
        }

        return $result;
    }


    /**
     * batch multiple request together
     * and return a proper response
     *
     * @param array $reqs an array of GuzzleHttp\Message\Request objects
     *
     * @return array hn\Item objects
     */
    public function batch(array $reqs) {

        $result = GuzzleHttp\batch($this, $reqs);

        $response = [];

        foreach ($reqs as $req) {
            $url = $req->getUrl();
            $resp = $result[$req];

            if (stripos($url, '/item/') !== false) {
                $response[$url] = $this->response($resp->json());
            }
            else if (stripos($url, '/user/') !== false) {
                $response[$url] = new Item\User($resp->json());
            }
            else {
                $response[$url] = $resp->json();
            }

        }

        return $response;
    }

}
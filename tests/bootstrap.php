<?php

namespace hn\Tests;

require __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Subscriber\Mock,
    GuzzleHttp\Message\Response,
    GuzzleHttp\Stream\Stream
;




class Test extends \PHPUnit_Framework_TestCase {

    public function setMock($client, $code, $content) {
        if (is_string($content) && file_exists(__DIR__ . "/data/{$content}.json")) {
            $content = file_get_contents(__DIR__ . "/data/{$content}.json");
        }

        $mock = new Mock([
                new Response(
                    $code,
                    [],
                    Stream::factory(is_array($content) ? json_decode($content) : $content)
                )
            ]);

        $client
            ->getEmitter()
            ->attach($mock);

        return $client;
    }

}
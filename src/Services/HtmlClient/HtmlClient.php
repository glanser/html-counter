<?php

declare(strict_types=1);

namespace HtmlParser\Services\HtmlClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HtmlParser\Services\Parser\HtmlDocument;

final class HtmlClient implements HtmlClientInterface
{
    public function __construct(
        private readonly Client $guzzleClient,
    ) {
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function request(string $method, string $url, array $options = []): HtmlDocument
    {
        $response = $this->guzzleClient->request($method, $url, $options);

        return new HtmlDocument($response->getBody()->getContents());
    }
}
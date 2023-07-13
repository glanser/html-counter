<?php

declare(strict_types=1);

namespace HtmlParser\Services\HtmlClient;

use HtmlParser\Services\Parser\HtmlDocument;

interface HtmlClientInterface
{
    public function request(string $method, string $url, array $options): HtmlDocument;
}
<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser;

use HtmlParser\Services\Parser\Entities\HtmlNode;

interface HtmlDocumentInterface
{
    public function getDom(): HtmlNode;

    public function countTags(): int;

    public function countNodes(): int;
}
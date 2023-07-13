<?php

declare(strict_types=1);

namespace HtmlParser\Services\TagCounter;

use HtmlParser\Services\Parser\HtmlDocument;
use HtmlParser\Services\TagCounter\Data\CountedTags;

interface TagCounterInterface
{
    public function execute(HtmlDocument $document): CountedTags;
}
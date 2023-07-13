<?php

declare(strict_types=1);

namespace HtmlParser\Services\TagCounter\Data;

use ArrayIterator;
use HtmlParser\Services\Parser\Entities\HtmlNode;
use IteratorAggregate;
use Traversable;

class CountedTags implements IteratorAggregate
{
    private array $tags = [];

    public function increment(HtmlNode $node): self
    {
        if (isset($this->tags[$node->tagName])) {
            $this->tags[$node->tagName]->increment();
        } else {
            $this->tags[$node->tagName] = new CountedTag($node->tagName);
        }

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->tags);
    }
}
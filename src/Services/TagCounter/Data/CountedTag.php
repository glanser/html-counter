<?php

declare(strict_types=1);

namespace HtmlParser\Services\TagCounter\Data;

class CountedTag
{
    public function __construct(
        private readonly string $tagName,
        private int $count = 1,
    ) {
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function increment(): self
    {
        $this->count++;

        return $this;
    }
}
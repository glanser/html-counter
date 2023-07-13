<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser\Entities;

final class HtmlNode
{
    public function __construct(
        public readonly string $tagName,
        public Attributes $attributes = new Attributes(),
        public HtmlNodes $children = new HtmlNodes(),
    ) {
    }

    public function countAllInnerTags(): int
    {
        $count = 0;

        foreach ($this->children as $child) {
            if (!($child instanceof self)) {
                continue;
            }

            $count += $child->countAllInnerTags();
            $count++;
        }

        return $count;
    }

    public function countAllInnerNodes(): int
    {
        $count = 0;

        foreach ($this->children as $child) {
            if ($child instanceof self) {
                $count += $child->countAllInnerNodes();
            }
            $count++;
        }

        return $count;
    }
}
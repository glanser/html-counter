<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser\Entities;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final class Attributes implements Countable, IteratorAggregate
{
    private array $attributes = [];

    public function add(Attribute $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    public function count(): int
    {
        return count($this->attributes);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }
}
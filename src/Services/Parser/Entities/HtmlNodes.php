<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser\Entities;

use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use Traversable;

final class HtmlNodes implements Countable, IteratorAggregate
{
    private array $nodes = [];

    public function add(HtmlNode | string $node): self
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function first(): HtmlNode | string
    {
        reset($this->nodes);

        return $this->nodes[0] ?? throw new Exception('First node not exists');
    }

    /**
     * @throws Exception
     */
    public function firstByTagName(string $tagName): HtmlNode
    {
        reset($this->nodes);

        $foundNodes = array_values(
            array_filter(
                $this->nodes,
                static fn(HtmlNode | string $node) => !is_string($node) && $node->tagName === $tagName
            )
        );

        return $foundNodes[0] ?? throw new Exception('First node with given tagName not exists');
    }

    /**
     * @throws Exception
     */
    public function firstTag(): HtmlNode
    {
        reset($this->nodes);

        foreach ($this->nodes as $node) {
            if ($node instanceof HtmlNode) {
                return $node;
            }
        }

        throw new Exception('First node with tag not exists');
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }
}
<?php

declare(strict_types=1);

namespace HtmlParser\Services\TagCounter;

use HtmlParser\Services\Parser\Entities\HtmlNode;
use HtmlParser\Services\Parser\HtmlDocument;
use HtmlParser\Services\TagCounter\Data\CountedTags;

class TagCounter implements TagCounterInterface
{
    public function execute(HtmlDocument $document): CountedTags
    {
        return $this->calculate($document->getDom(), new CountedTags());
    }

    private function calculate(HtmlNode $node, CountedTags $countedTags): CountedTags
    {
        $countedTags->increment($node);

        foreach ($node->children as $child) {
            if (!is_string($child)) {
                $this->calculate($child, $countedTags);
            }
        }

        return $countedTags;
    }
}
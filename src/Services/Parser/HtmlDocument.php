<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser;

use Exception;
use HtmlParser\Services\Parser\Entities\Attribute;
use HtmlParser\Services\Parser\Entities\Attributes;
use HtmlParser\Services\Parser\Entities\HtmlNode;

final class HtmlDocument implements HtmlDocumentInterface
{
    private HtmlNode $dom;
    private array    $selfClosingTags = [
        'area',
        'base',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    /**
     * @throws Exception
     */
    public function __construct(
        public readonly string $content
    ) {
        $htmlContent = $this->getHtmlContent($this->content);
        $this->dom   = $this->parse($htmlContent);
    }

    public function getDom(): HtmlNode
    {
        return $this->dom;
    }

    public function countTags(): int
    {
        return $this->dom->countAllInnerTags() + 1;
    }

    public function countNodes(): int
    {
        return $this->dom->countAllInnerNodes() + 1;
    }

    /**
     * @throws Exception
     */
    private function getHtmlContent(string $html): string
    {
        preg_match('#(<html.*</html>)#s', $html, $matches);

        if (empty($matches)) {
            throw new Exception('html tag not found');
        }

        return $matches[1];
    }

    /**
     * @throws Exception
     */
    private function parse(string $html): HtmlNode
    {
        $dom         = new HtmlNode('');
        $stack       = [$dom];
        $currentNode = $dom;
        $symbols     = mb_str_split($html);

        $length = count($symbols);
        $i      = 0;

        while ($i < $length) {
            $char = $symbols[$i];

            if ($char === '<' && $symbols[$i + 1] === '/') {
                // closing tag
                $i   = $i + 2;
                $tag = '';

                while ($i < $length && $symbols[$i] !== '>') {
                    $tag .= $symbols[$i];
                    $i++;
                }

                if ($symbols[$i] === '>' && !empty($tag)) {
                    while (!empty($stack)) {
                        $node = array_pop($stack);
                        if ($node->tagName === $tag) {
                            $currentNode = end($stack);
                            break;
                        }
                    }
                    $i++;
                }
            } elseif ($char === '<') {
                $tag  = '';
                $attr = '';

                $i++;

                // Read name of tag
                while ($i < $length && $symbols[$i] !== ' ' && $symbols[$i] !== '>') {
                    $tag .= $symbols[$i];
                    $i++;
                }

                // attributes
                while ($i < $length && $symbols[$i] !== '>') {
                    $attr .= $symbols[$i];
                    $i++;
                }

                if ($symbols[$i] === '>') {
                    // opening tag
                    $node             = new HtmlNode($tag);
                    $node->attributes = $this->parseAttributes($attr);
                    $currentNode->children->add($node);

                    if (!in_array($tag, $this->selfClosingTags)) {
                        $stack[]     = $node;
                        $currentNode = $node;
                    }
                    $i++;
                }
            } else {
                // text node
                $text = '';

                while ($i < $length && $symbols[$i] !== '<') {
                    $text .= $symbols[$i];
                    $i++;
                }

                if ($text !== '') {
                    $currentNode->children->add($text);
                }
            }
        }

        return $dom->children->firstTag();
    }

    private function parseAttributes(string $string): Attributes
    {
        preg_match_all('#\s+(\w+)\s*(?:=\s*["\'](.*?)["\'])?#', $string, $matches, PREG_SET_ORDER);

        $attributes = new Attributes();

        foreach ($matches as $match) {
            $attributeName  = $match[1];
            $attributeValue = $match[2] ?? null;

            $attributes->add(new Attribute($attributeName, $attributeValue));
        }


        return $attributes;
    }
}
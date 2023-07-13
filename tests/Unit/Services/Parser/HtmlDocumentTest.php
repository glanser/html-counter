<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Parser;

use Exception;
use HtmlParser\Services\Parser\HtmlDocument;
use PHPUnit\Framework\TestCase;

class HtmlDocumentTest extends TestCase
{
    public static function htmlDataProvider(): array
    {
        return [
            'simple_tags'       => [
                'stub_1_simple_tags.html',
                24,
                66,
            ],
            'self_closing_tags' => [
                'stub_2_with_self_closing_tag.html',
                25,
                68,
            ],
            'one_line'          => [
                'stub_4_one_line.html',
                24,
                35,
            ],
            'many_meta'         => [
                'stub_5_lot_of_meta.html',
                10,
                23,
            ],
            '5_tags'            => [
                'stub_6_only_5_tags.html',
                5,
                13,
            ],
        ];
    }

    /**
     * @dataProvider htmlDataProvider
     * @throws Exception
     */
    public function testCreateDomFromHtml(string $stubFileName, int $expectedTags, int $expectedNodes): void
    {
        $content  = file_get_contents(dirname(__FILE__) . '/stubs/' . $stubFileName);
        $document = new HtmlDocument($content);

        $this->assertEquals($expectedTags, $document->countTags());
        $this->assertEquals($expectedNodes, $document->countNodes());
    }

    /**
     * @dataProvider htmlDataProvider
     * @throws Exception
     */
    public function testCreateDomFromHtmlWithoutHtmlTag(): void
    {
        $content = file_get_contents(dirname(__FILE__) . '/stubs/stub_3_without_html_tag.html');
        $this->expectException(Exception::class);

        new HtmlDocument($content);
    }

    /**
     * @throws Exception
     */
    public function testCreateDomFromHtmlWithAttributes(): void
    {
        $content  = file_get_contents(dirname(__FILE__) . '/stubs/stub_7_attributes.html');
        $document = new HtmlDocument($content);

        $footerTagNode = $document->getDom()
            ->children->firstByTagName('body')
            ->children->firstByTagName('footer');

        $this->assertCount(3, $footerTagNode->attributes);
    }
}
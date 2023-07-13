<?php

declare(strict_types=1);

namespace HtmlParser\Services\Parser\Entities;

final class Attribute
{
    public function __construct(
        public readonly string $name,
        public ?string $value = null,
    ) {
    }
}
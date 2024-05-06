<?php

namespace App\DataTransferObject;

use App\Entity\Tag;

final class ArticleFilterDto
{
    private null|string $keyword = null;

    private Tag|null $tag = null;

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(?string $keyword): void
    {
        $this->keyword = $keyword;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): void
    {
        $this->tag = $tag;
    }
}
<?php

namespace App\DataTransferObject;

use Doctrine\Common\Collections\ArrayCollection;

final class ArticleFilterDto
{
    private null|string $keyword = null;
    private ArrayCollection|null $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(?string $keyword): void
    {
        $this->keyword = $keyword;
    }

    public function getTags(): ArrayCollection
    {
        return $this->tags;
    }

    public function setTags(ArrayCollection $tags): void
    {
        $this->tags = $tags;
    }


}
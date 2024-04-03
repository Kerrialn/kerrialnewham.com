<?php

namespace App\DataTransferObject;

use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;

final class ArticleFilterDto
{
    private null|string $keyword = null;

    /**
     * @var ArrayCollection<int,Tag>|null
     */
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


    /**
     * @return ArrayCollection<int,Tag>
     */
    public function getTags(): ArrayCollection
    {
        return $this->tags;
    }


    /**
     * @param ArrayCollection<int,Tag> $tags
     */
    public function setTags(ArrayCollection $tags): void
    {
        $this->tags = $tags;
    }


}
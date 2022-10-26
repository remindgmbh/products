<?php

declare(strict_types=1);

namespace Remind\Products\Domain\Model;

use Remind\Extbase\Domain\Model\AbstractJsonSerializableEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Product extends AbstractJsonSerializableEntity
{
    protected string $articleNumber = '';
    protected string $title = '';
    protected string $description = '';
    protected string $slug = '';
    /**
     * @var ObjectStorage<FileReference> $images
     */
    protected ObjectStorage $images;

    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    public function setArticleNumber(string $articleNumber): self
    {
        $this->articleNumber = $articleNumber;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addImage(FileReference $image)
    {
        $this->images->attach($image);
    }

    public function removeImage(FileReference $image)
    {
        $this->images->detach($image);
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    /**
     * @param ObjectStorage<FileReference> $images
     */
    public function setImages(ObjectStorage $images): self
    {
        $this->images = $images;

        return $this;
    }
}

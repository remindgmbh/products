<?php

declare(strict_types=1);

namespace Remind\Products\Traits;

use Remind\Products\Traits\ProductAwareInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

interface MultiProductAwareInterface extends ProductAwareInterface
{
    /**
     * @return ObjectStorage<\Remind\Products\Domain\Model\Product>
     */
    public function getProducts(): ObjectStorage;

    /**
     * @param ObjectStorage<\Remind\Products\Domain\Model\Product> $products
     */
    public function setProducts(ObjectStorage $products): self;
}

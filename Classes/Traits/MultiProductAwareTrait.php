<?php

declare(strict_types=1);

namespace Remind\Products\Traits;

use Remind\Products\Domain\Model\Product;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

trait MultiProductAwareTrait
{
    /**
     * @var ObjectStorage<Product> $products
     */
    protected ObjectStorage $products;

    public function getProduct(): Product
    {
        $this->products->rewind();
        return $this->products->current();
    }

    public function addProduct(Product $product): void
    {
        $this->products->attach($product);
    }

    public function removeProduct(Product $product): void
    {
        $this->products->detach($product);
    }

    /**
     * @return ObjectStorage<Product>
     */
    public function getProducts(): ObjectStorage
    {
        return $this->products;
    }

    /**
     * @param ObjectStorage<Product> $products
     */
    public function setProducts(ObjectStorage $products): self
    {
        $this->products = $products;

        return $this;
    }
}

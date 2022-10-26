<?php

declare(strict_types=1);

namespace Remind\Products\Traits;

use Remind\Products\Domain\Model\Product;

trait SingleProductAwareTrait
{
    protected ?Product $product;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}

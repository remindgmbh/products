<?php

declare(strict_types=1);

namespace Remind\Products\Traits;

use Remind\Products\Domain\Model\Product;

interface SingleProductAwareInterface extends ProductAwareInterface
{
    public function setProduct(?Product $product): self;
}

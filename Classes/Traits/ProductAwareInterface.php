<?php

declare(strict_types=1);

namespace Remind\Products\Traits;

use Remind\Products\Domain\Model\Product;

interface ProductAwareInterface
{
    public function getProduct(): ?Product;
}

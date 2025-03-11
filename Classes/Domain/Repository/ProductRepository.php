<?php

declare(strict_types=1);

namespace Remind\Products\Domain\Repository;

use Remind\Extbase\Domain\Repository\FilterableRepository;

/**
 * @template-extends FilterableRepository<\Remind\Products\Domain\Model\Product>
 */
class ProductRepository extends FilterableRepository
{
}

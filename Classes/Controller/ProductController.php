<?php

declare(strict_types=1);

namespace Remind\Products\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Extbase\Controller\AbstractExtbaseController;
use Remind\Products\Domain\Model\Product;
use Remind\Products\Domain\Repository\ProductRepository;

class ProductController extends AbstractExtbaseController
{
    public function __construct(
        ProductRepository $productRepository,
    ) {
        parent::__construct($productRepository);
    }

    /**
     * @param mixed[] $filter
     */
    public function filterableListAction(int $page = 1, array $filter = []): ResponseInterface
    {
        $listResult = $this->getFilterableList($page, $filter, 'filter');

        $jsonResult = $this->serializeFilterableList(
            $listResult,
            $page,
            'detail',
            'product',
        );

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }

    public function selectionListAction(int $page = 1): ResponseInterface
    {
        $selectionResult = $this->getSelectionList($page);

        $jsonResult = $this->serializeList(
            $selectionResult,
            $page,
            'detail',
            'product'
        );

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }

    public function detailAction(?Product $product = null): ResponseInterface
    {
        $detailResult = $this->getDetailResult($product);

        $jsonResult = $detailResult ? $this->serializeDetailResult($detailResult) : [];

        return $this->jsonResponse(json_encode($jsonResult) ?: null);
    }
}

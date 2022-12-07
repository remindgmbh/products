<?php

declare(strict_types=1);

namespace Remind\Products\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Extbase\Service\DataService;
use Remind\Headless\Service\JsonService;
use Remind\Products\Domain\Model\Product;
use Remind\Products\Domain\Repository\ProductRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly DataService $dataService,
        private readonly JsonService $jsonService,
    ) {
    }

    public function filterableListAction(?int $page = 1, array $filter = []): ResponseInterface
    {
        $listResult = $this->dataService->getFilterableList($this->productRepository, $page, $filter, 'filter');

        $jsonResult = $this->jsonService->serializeFilterableList(
            $listResult,
            $page,
            'detail',
            'product',
        );

        return $this->jsonResponse(json_encode($jsonResult));
    }

    public function detailAction(?Product $product = null): ResponseInterface
    {
        /** @var Product|null $product */
        $product = $this->dataService->getDetailEntity(
            $this->productRepository,
            $product,
            function () {
            }
        );
        return $this->jsonResponse(json_encode(['product' => $product?->jsonSerialize()]));
    }
}

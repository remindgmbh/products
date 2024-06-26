<?php

declare(strict_types=1);

namespace Remind\Products\Controller;

use Psr\Http\Message\ResponseInterface;
use Remind\Extbase\Service\ControllerService;
use Remind\Extbase\Service\JsonService;
use Remind\Products\Domain\Model\Product;
use Remind\Products\Domain\Repository\ProductRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ControllerService $controllerService,
        private readonly JsonService $jsonService,
    ) {
    }

    public function filterableListAction(?int $page = 1, array $filter = []): ResponseInterface
    {
        $listResult = $this->controllerService->getFilterableList($this->productRepository, $page, $filter, 'filter');

        $jsonResult = $this->jsonService->serializeFilterableList(
            $listResult,
            $page,
            'detail',
            'product',
        );

        return $this->jsonResponse(json_encode($jsonResult));
    }

    public function selectionListAction(?int $page = 1): ResponseInterface
    {
        $selectionResult = $this->controllerService->getSelectionList($this->productRepository, $page);

        $jsonResult = $this->jsonService->serializeList(
            $selectionResult,
            $page,
            'detail',
            'product'
        );

        return $this->jsonResponse(json_encode($jsonResult));
    }

    public function detailAction(?Product $product = null): ResponseInterface
    {
        $detailResult = $this->controllerService->getDetailResult(
            $this->productRepository,
            $product
        );
        return $this->jsonResponse(json_encode($detailResult));
    }
}

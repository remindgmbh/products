<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'productsfilterablelist' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_products/Resources/Public/Icons/products_filterable_list.svg',
    ],
    'productsselectionlist' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_products/Resources/Public/Icons/products_selection_list.svg',
    ],
    'productsdetail' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:rmnd_products/Resources/Public/Icons/products_detail.svg',
    ],
];

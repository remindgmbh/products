<?php

declare(strict_types=1);

use Remind\Extbase\Utility\Dto\PluginType;
use Remind\Extbase\Utility\PluginUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die;

(function () {
    ExtensionUtility::registerPlugin(
        'Products',
        'FilterableList',
        'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:filterableList',
        'productsfilterablelist',
        'Products'
    );

    PluginUtility::addTcaType('products_list', PluginType::FILTERABLE_LIST);

    ExtensionUtility::registerPlugin(
        'Products',
        'Detail',
        'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:detail',
        'productsdetail',
        'Products'
    );

    PluginUtility::addTcaType('products_detail', PluginType::DETAIL, 'tx_products_domain_model_product');
})();

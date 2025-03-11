<?php

declare(strict_types=1);

use Remind\Products\Controller\ProductController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

(function (): void {
    ExtensionUtility::configurePlugin(
        'Products',
        'FilterableList',
        [ProductController::class => 'filterableList'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Products',
        'SelectionList',
        [ProductController::class => 'selectionList'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    ExtensionUtility::configurePlugin(
        'Products',
        'Detail',
        [ProductController::class => 'detail'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
})();

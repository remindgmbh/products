<?php

declare(strict_types=1);

defined('TYPO3') or die;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function (): void {
    ExtensionManagementUtility::addStaticFile(
        'rmnd_products',
        'Configuration/TypoScript',
        'REMIND - Products Extension'
    );
})();

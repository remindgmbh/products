<?php

defined('TYPO3') or die;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addStaticFile(
        'rmnd_products',
        'Configuration/TypoScript',
        'REMIND - Products Extension'
    );
})();

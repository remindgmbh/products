<?php

declare(strict_types=1);

namespace Remind\Products\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class ExtensionUtility
{
    /**
     * @param string $table the product column is added to
     * @return string Name of the added field
     */
    public static function addTcaColumnProduct(string $table): string
    {
        $fieldName = 'product';
        ExtensionManagementUtility::addTCAcolumns($table, [
            $fieldName => [
                'config' => [
                    'default' => 0,
                    'foreign_table' => 'tx_products_domain_model_product',
                    'items' => [
                        ['', 0],
                    ],
                    'maxitems' => 1,
                    'minitems' => 0,
                    'renderType' => 'selectSingle',
                    'type' => 'select',
                ],
                'exclude' => false,
                'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:product',
            ],
        ]);
        return $fieldName;
    }

    /**
     * @param string $table the products column is added to
     * @param string $mm name of the mm table
     * @param bool $foreign required to make field editable from foreign side
     * @return string Name of the added field
     */
    public static function addTcaColumnProducts(string $table, string $mm, bool $foreign = false): string
    {
        $fieldName = 'products';
        $column = [
            $fieldName => [
                'config' => [
                    'foreign_table' => 'tx_products_domain_model_product',
                    'MM' => $mm,
                    'multiple' => 0,
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 5,
                    'type' => 'select',
                ],
                'exclude' => false,
                'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:products',
            ],
        ];

        if ($foreign) {
            $column[$fieldName]['config']['MM_opposite_field'] = $fieldName;
        }

        ExtensionManagementUtility::addTCAcolumns($table, $column);

        return $fieldName;
    }
}

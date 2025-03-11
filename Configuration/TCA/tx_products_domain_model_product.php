<?php

declare(strict_types=1);

return [
    'columns' => [
        'article_number' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 20,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:articleNumber',
        ],
        'description' => [
            'config' => [
                'enableRichtext' => true,
                'eval' => 'trim',
                'required' => false,
                'type' => 'text',
            ],
            'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:description',
        ],
        'images' => [
            'config' => [
                'allowed' => 'common-image-types',
                'type' => 'file',
            ],
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.images',
        ],
        'name' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'required' => false,
                'size' => 20,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:name',
        ],
        'slug' => [
            'config' => [
                'default' => '',
                'eval' => 'uniqueInSite',
                'fallbackCharacter' => '-',
                'generatorOptions' => [
                    'fields' => ['name'],
                    'prefixParentPageSlug' => false,
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'type' => 'slug',
            ],
            'exclude' => 0,
            'label' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:slug',
        ],
    ],
    'ctrl' => [
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_products/Resources/Public/Icons/tx_products_domain_model_product.svg',
        'label' => 'name',
        'languageField' => 'sys_language_uid',
        'origUid' => 't3_origuid',
        'sortby' => 'sorting',
        'title' => 'LLL:EXT:rmnd_products/Resources/Private/Language/locallang_tca.xlf:product',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'tstamp' => 'tstamp',
        'versioningWS' => true,
    ],
    'palettes' => [
        'general' => [
            'showitem' => '
                article_number,
                --linebreak--,
                name,
                --linebreak--,
                slug,
                --linebreak--,
                description,
            ',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,
                    images,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid,
                    l10n_parent,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
];

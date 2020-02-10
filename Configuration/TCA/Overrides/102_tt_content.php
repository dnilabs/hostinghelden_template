<?php

/*
 * This file is part of the package bk2k/bootstrap-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

/***************
 * Add content element group to selector list
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
  'tt_content',
  'CType',
  [
    'LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:theme_name',
    '--div--'
  ],
  '--div--',
  'before'
);

/***************
 * Register fields
 */
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
  $GLOBALS['TCA']['tt_content']['columns'],
  [
    'visibility' => [
      'exclude' => 0,
      'displayCond' => 'FIELD:frame_class:!=:none',
      'label' => 'Sichtbarkeit Responsive',
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
          ['not set',  ''],
          ['Hidden on all', 'd-none'],
          ['Hidden on Smartphone', 'd-none d-md-block'],
          ['Hidden on Desktop', 'd-md-none d-lg-none d-xl-none'],
          ['Hidden only on xs','d-none d-sm-block'],
          ['Hidden only on sm','d-sm-none d-md-block'],
          ['Hidden only on md','d-md-none d-lg-block'],
          ['Hidden only on lg','d-lg-none d-xl-block'],
          ['Hidden only on xl ','d-xl-none'],
          ['Visible only on Smartphone', 'd-md-none d-lg-none d-xl-none'],
          ['Visible only on Desktop', 'd-none d-md-block'],
          ['Visible only on xs','d-block d-sm-none'],
          ['Visible only on sm','d-none d-sm-block d-md-none'],
          ['Visible only on md','d-none d-md-block d-lg-none'],
          ['Visible only on lg','d-none d-lg-block d-xl-none'],
          ['Visible only on xl','d-none d-xl-block']
        ],
        'size' => 1,
        'maxitems' => 1,
      ]
    ],
    'textpic_ratio' => [
      'label' => 'Bild / Text Verhältnis',
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
          ['50/50', 0],
          ['33/66', 1],
          ['25/75', 2]
        ]
      ]
    ]
  ]
);


$GLOBALS['TCA']['tt_content']['palettes']['frames']['showitem'] .= ',--linebreak--, visibility,--linebreak--;';


/***************
 * Add additional fields
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
  'tt_content',
  'textpic_ratio',
  'textpic',
  'after:imageorient'
);
/***************
 * Add additional fields
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
  'tt_content',
  'textpic_ratio',
  'textmedia',
  'after:imageorient'
);

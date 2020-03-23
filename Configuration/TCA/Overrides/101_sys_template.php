<?php

defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'hostinghelden_template',
    'Configuration/TypoScript',
    'hostinghelden template'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'hostinghelden_template',
    'Configuration/TypoScript/Newsletter',
    'hostinghelden newsletter'
);

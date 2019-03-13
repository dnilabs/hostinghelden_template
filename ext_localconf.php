<?php

defined('TYPO3_MODE') || die();

// Scheduler Tasks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Hostinghelden\HostingheldenTemplate\Task\DeleteCriticalTask'] = array(
 'extension' => $_EXTKEY,
 'title' => 'Delete Critical CSS Files',
 'description' => 'This Task deletes all critical css files.',
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Hostinghelden\HostingheldenTemplate\Task\NewsletterActivationTask'] = array(
 'extension' => $_EXTKEY,
 'title' => 'Create Newsletter Opt-In Email',
 'description' => 'Create Email for Newsletter OptIn for all hidden tt_address Records!!! every hidden record with email will get an email',
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Hostinghelden\HostingheldenTemplate\Task\DisableNewsletterAddressesTask'] = array(
 'extension' => $_EXTKEY,
 'title' => 'Disable all Newsletter Subscriptions',
 'description' => 'This Task sets all tt_records to hidden, which will disable the newsletter for that address, the addressen which dont get activated have to be deleted manually',
);

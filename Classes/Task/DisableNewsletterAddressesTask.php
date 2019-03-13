<?php
namespace Hostinghelden\HostingheldenTemplate\Task;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;


class DisableNewsletterAddressesTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

  public function execute() {
    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
    $queryBuilder
      ->update('tt_address')
      ->set('hidden', 1)
      ->execute();

    return true;
  }


}
